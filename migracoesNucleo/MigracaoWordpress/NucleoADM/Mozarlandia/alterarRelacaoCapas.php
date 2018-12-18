<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 08/10/2018
 * Time: 13:50
 */

date_default_timezone_set("America/Sao_Paulo");
header("Content-Type: text/html; charset=utf-8");
mb_internal_encoding("UTF-8");

set_time_limit(5 * 60);

//$conOrigem = new PDO("mysql:dbname=cabeceiras;host=localhost", "root", "1234", $options = array(
//    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
//    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//    PDO::ATTR_PERSISTENT => false
//));

$conDestino = new PDO("mysql:dbname=mozarlandia_nucleoweb;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

// ALTERAR PARA USAR NO CAMPO GUID QUE É O DOMÍNIO DO SITE
const SITE = "http://192.168.254.222/NucleoWeb/wordpress/";
const ARQUIVOS = SITE . "wp-content/uploads/";
//ALTERAR ID PARA SELECIONAR AS MÍDIAS REFERENTES À MIGRAÇÃO
const ID = 1680;

try {
    $conDestino->beginTransaction();

    $query = $conDestino->prepare('
        SELECT * FROM ng_postmeta where meta_key="_wp_attached_file" and meta_id > ' . ID
    );

    $bool = $query->execute();

    if ($bool) {
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $i => $v) {
            $meta = $v['meta_value'];
            $meta_id = $v['meta_id'];

            $post_id = explode("/", explode("_", $meta)[0])[2];

            $midia_nome = explode(".", explode("/", $meta)[2])[0];

            $query_post = $conDestino->prepare('
        SELECT * FROM ng_posts where post_title="' . $midia_nome . '"'
            );

            $bool_post = $query_post->execute();
            if ($bool_post) {
                $result_post = $query_post->fetchAll(PDO::FETCH_ASSOC);

                $post_meta_id = $result_post[0]['ID'];
                if ($post_id > 0) {
                    echo $post_id . "<br>";

                    $query_relacao_post_capa = $conDestino->prepare("INSERT INTO ng_postmeta(meta_id, post_id, meta_key, meta_value) values(null, ?,'_thumbnail_id', ?)");
                    $query_relacao_post_capa->bindValue(1, $post_id);
                    $query_relacao_post_capa->bindValue(2, $post_meta_id);

                    $query_relacao_post_capa->execute();

                } else {
                    throw new Exception("ID do post não é válido. Linha: " . $i);
                }
            }
        }
    }

    $conDestino->commit();

} catch (\Exception $e) {
    $conDestino->rollBack();
    echo $e->getMessage() . "<br>";
    echo "falha ao inserir relacao capa post na linha " . $i;
} finally {
    //unset($conOrigem);
    unset($conDestino);
}

?>