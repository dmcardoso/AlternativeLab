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

//$conOrigem = new PDO("mysql:dbname=muricilandia;host=localhost", "root", "1234", $options = array(
//    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
//    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//    PDO::ATTR_PERSISTENT => false
//));

$conDestino = new PDO("mysql:dbname=padrao_itaguatins;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

// ALTERAR PARA USAR NO CAMPO GUID QUE É O DOMÍNIO DO SITE
const SITE = "http://192.168.254.222/NucleoWeb/wordpress/";
const ARQUIVOS = SITE . "wp-content/uploads/";

//ALTERAR ID PARA SELECIONAR AS MÍDIAS REFERENTES À MIGRAÇÃO
const ID = 1178;

//Alterar se o prefixo das tabelas for diferente
$prefixo_tabela = "ng_";

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
                            $type_page_query = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'_wp_page_template', 'page-foto-topo.php')");
                            $type_page_query->bindValue(1, $post_id);
                            $type_page_query->execute();
                            echo "Tipo de página para institucional: {$post_id} <br>";

                            $foto_campo_query = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'_foto', 'field_5b5ece16fa778')");
                            $foto_campo_query->bindValue(1, $post_id);
                            $foto_campo_query->execute();
                            echo "Campo foto para institucional: {$post_id} <br>";

                            $valor_campo_foto_query = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'foto', ?)");
                            $valor_campo_foto_query->bindValue(1, $post_id);
                            $valor_campo_foto_query->bindValue(2, $post_meta_id);
                            $valor_campo_foto_query->execute();
                            echo "Valor campo foto para institucional: {$post_id} <br>";
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

            $query_relacao_post_capa = $conDestino->prepare("update {$prefixo_tabela}posts set post_content = concat(post_content, ?) where id = ?");

            $query_relacao_post_capa->bindValue(1, $galeria);
            $query_relacao_post_capa->bindValue(2, $i);

            $query_relacao_post_capa->execute();

            echo "Galeria inserida em página {$i} <br>";
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