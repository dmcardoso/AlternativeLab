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
const ID = 1696;

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

//        echo "<pre>";
//        print_r($result);
//        echo count($result);
//        die;

        foreach ($result as $i => $v) {
            $meta = $v['meta_value'];
            $meta_id = $v['post_id'];
//            $post_id_meta = $v['id'];


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
//die;

            if (isset($type_midia) && isset($post_id)) {
                $query_post = $conDestino->prepare("
        SELECT * FROM {$prefixo_tabela}posts where ID='" . $meta_id . "'"
                );
                $query_video = $conDestino->prepare("
        SELECT * FROM {$prefixo_tabela}posts where ID='" . $post_id . "'"
                );

                $bool_post = $query_post->execute();
                $bool_video = $query_video->execute();
                if ($bool_post) {
                    $result_post = $query_post->fetchAll(PDO::FETCH_ASSOC);
                    $result_video = $query_video->fetchAll(PDO::FETCH_ASSOC);

//                echo "<pre>";
//                print_r($result_post);
//                die;

                    if (isset($result_post[0])) {
                        $post_meta_id = $result_post[0]['ID'];
                        $video = $result_video[0]['post_content'];

                        if ($type_midia == "capa") {
                            $query_relacao_post_capa = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'miniatura', ?)");
                            $query_relacao_post_capa->bindValue(1, $post_id);
                            $query_relacao_post_capa->bindValue(2, $post_meta_id);
//
                            $query_relacao_post_capa->execute();

                            $query_relacao_post_miniatura = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'_miniatura', 'field_5b5d8d98caf5d')");
                            $query_relacao_post_miniatura->bindValue(1, $post_id);
//
                            $query_relacao_post_miniatura->execute();
                            echo "Capa para galeria {$post_id} <br>";
                        }

                        if($video != ""){
                            $query_relacao_video_link = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'youtube', ?)");
                            $query_relacao_video_link->bindValue(1, $post_id);
                            $query_relacao_video_link->bindValue(2, $video);
//
                            $query_relacao_video_link->execute();

                            $query_relacao_video__ = $conDestino->prepare("INSERT INTO {$prefixo_tabela}postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'_youtube', 'field_5b5d8d7fcaf5c')");
                            $query_relacao_video__->bindValue(1, $post_id);
//
                            $query_relacao_video__->execute();

                            $update_query_video =  $conDestino->prepare("UPDATE {$prefixo_tabela}posts set post_content = '' where ID = ?");
                            $update_query_video->bindValue(1, $post_id);
                            $update_query_video->execute();

                            echo "Link para o vídeo {$post_id} <br><br>";
                        }
                    }
                }
            }
        }
    }


    echo "<pre>";
    echo "Relações: " . $contador . "<br>";

    $conDestino->commit();

} catch (\Exception $e) {
    $conDestino->rollBack();
    echo $e->getMessage();
} finally {
    unset($conOrigem);
    unset($conDestino);
}
?>