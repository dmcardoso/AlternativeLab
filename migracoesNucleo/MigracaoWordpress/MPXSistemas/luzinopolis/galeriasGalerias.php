<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 22/10/2018
 * Time: 11:23
 */

date_default_timezone_set("America/Sao_Paulo");
header("Content-Type: text/html; charset=utf-8");
mb_internal_encoding("UTF-8");

set_time_limit(5 * 60);

require './configs.php';


//$conOrigem = new PDO("mysql:dbname=muricilandia;host=localhost", "root", "1234", $options = array(
//    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
//    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//    PDO::ATTR_PERSISTENT => false
//));
$dbDestino = DBDESTINO;
$conDestino = new PDO("mysql:dbname={$dbDestino};host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

// ALTERAR PARA USAR NO CAMPO GUID QUE É O DOMÍNIO DO SITE
const SITE = "http://192.168.254.222/NucleoWeb/wordpress/";
const ARQUIVOS = SITE . "wp-content/uploads/";

//ALTERAR ID PARA SELECIONAR AS MÍDIAS REFERENTES À MIGRAÇÃO
const ID = IDGALLERY;

//Alterar se o prefixo das tabelas for diferente
$prefixo_tabela = PREFIXO;

try {
    $conDestino->beginTransaction();

    $query = $conDestino->prepare("
        SELECT * FROM {$prefixo_tabela}postmeta where meta_key='_wp_attached_file' and meta_id > " . ID
    );

    $bool = $query->execute();

    if ($bool) {
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $contador = 0;
        $galerias = [];

//        echo "<pre>";
//        print_r($result);
//        echo count($result);
//        die;

        foreach ($result as $i => $v) {
            $meta = $v['meta_value'];
            $meta_id = $v['post_id'];


            $midia_nome = explode(".", explode("/", $meta)[2])[0];

            $nome = explode("/", $meta)[2];

            if (isset(explode("_", $nome)[2]) && (explode("_", $nome)[1] == "galeria" || explode("_", $nome)[1] == "capa")) {
                $post_id = explode("/", explode("_", $meta)[0])[2];
                $type_midia = explode("_", $nome)[1];
                $contador++;
//                echo $post_id . $type_midia . "<br>";
            }

//            echo $post_id . "<br>";
//            echo $midia_nome . "<br>";


            if (isset($type_midia) && isset($post_id)) {
                $query_post = $conDestino->prepare("
        SELECT * FROM {$prefixo_tabela}posts where ID='" . $meta_id . "'"
                );

                $bool_post = $query_post->execute();
                if ($bool_post) {
                    $result_post = $query_post->fetchAll(PDO::FETCH_ASSOC);

//                echo "<pre>";
//                print_r($result_post);

                    if (isset($result_post[0])) {
                        if (array_key_exists($post_id, $galerias) && $type_midia == "galeria") {
                            $galerias[$post_id][] = $result_post[0]['ID'];
                        } else if (!array_key_exists($post_id, $galerias) && $type_midia == "galeria") {
                            $galerias[$post_id][] = $result_post[0]['ID'];
                        }

                        $post_meta_id = $result_post[0]['ID'];

                        if ($type_midia == "capa") {
                            $query_relacao_post_capa = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'miniatura', ?)");
                            $query_relacao_post_capa->bindValue(1, $post_id);
                            $query_relacao_post_capa->bindValue(2, $post_meta_id);
//
                            $query_relacao_post_capa->execute();

                            $query_relacao_post_miniatura = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'_miniatura', 'field_5b5ec69578a1c')");
                            $query_relacao_post_miniatura->bindValue(1, $post_id);
//
                            $query_relacao_post_miniatura->execute();
                            echo "Capa para galeria {$post_id} <br>";
                        }
                    }
                }
            }
        }
    }

    if (count($galerias) > 0) {
        $contaGaleria = 0;
        foreach ($galerias as $i => $v) {
            $contaGaleria++;
            $ids = implode($v, ",");
            $galeria = '[gallery link="file" ids="' . $ids . '"]';

            $query_relacao_post_capa = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'galeria', ?)");
            $query_relacao_post_capa->bindValue(1, $i);
            $query_relacao_post_capa->bindValue(2, $galeria);
//
            $query_relacao_post_capa->execute();

            $query_relacao_galeria = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'_galeria', 'field_5b5ec6a178a1d')");

            $query_relacao_galeria->bindValue(1, $i);

            $query_relacao_galeria->execute();

            echo "Galeria inserida em notícia {$i} <br>";
        }
    }

    echo "<pre>";
//    print_r($galerias);
    echo "Galerias: " . count($galerias) . "<br>";
    echo "Relações: " . $contador . "<br>" . "Galerias inseridas: " . $contaGaleria;

    $conDestino->commit();

} catch (\Exception $e) {
    $conDestino->rollBack();
    echo $e->getMessage();
} finally {
    unset($conOrigem);
    unset($conDestino);
}
?>