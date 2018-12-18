<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 05/10/2018
 * Time: 13:37
 */
date_default_timezone_set("America/Sao_Paulo");
header("Content-Type: text/html; charset=utf-8");
mb_internal_encoding("UTF-8");

set_time_limit(5 * 60);

$conOrigem = new PDO("mysql:dbname=mozarlandia_padrao;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

$conDestino = new PDO("mysql:dbname=mozarlandia_nucleoweb;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

// ALTERAR PARA USAR NO CAMPO GUID QUE É O DOMÍNIO DO SITE
const SITE = "http://192.168.254.222/NucleoWeb/wordpress/";
const ARQUIVOS = SITE . "wp-content/uploads/";

try {
    $conDestino->beginTransaction();


    $query = $conOrigem->prepare("
        SELECT
            n.data,
            n.texto,
            n.titulo,
            mi.titulo as midia_titulo,
            mi.midia
        FROM
            noticias n
            LEFT JOIN midias_uso m ON n.capa = m.id
            INNER JOIN midias mi ON mi.id = m.midia_id"
    );

    $bool = $query->execute();

    if ($bool) {
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
//        echo "<pre>";
//        print_r($result);


        foreach ($result as $i => $v) {

            $midia = $v['midia'];
            $midia_titulo = $v['midia_titulo'];
            $data = $v['data'];
            $timestamp = strtotime($data) + (3 * (60 * 60));
            $data_gmt = strftime('%Y-%m-%d %H:%M:%S', $timestamp);
            $texto = $v['texto'];
            $titulo = $v['titulo'];
            $slug = removeAcentos($titulo, "-");
            $mimtype = mime_content_type("antigo/" . $midia);

            $ano_publicacao = explode("-", explode(" ", $data)[0])[0];
            $mes_publicacao = explode("-", explode(" ", $data)[0])[1];

            if (!is_dir("novo/" . $ano_publicacao)) {
                mkdir("novo/" . $ano_publicacao);
            }
            if (!is_dir("novo/" . $ano_publicacao . '/' . $mes_publicacao)) {
                mkdir("novo/" . $ano_publicacao . '/' . $mes_publicacao);
            }

            $relacao_pasta = $ano_publicacao . '/' . explode("-", explode(" ", $data)[0])[1] . "/";


            $query = $conDestino->prepare("INSERT INTO ng_posts 
                (ID,
                post_author,
                post_date,
                post_date_gmt,
                post_content,
                post_title,
                post_excerpt,
                post_status,
                comment_status,
                ping_status,
                post_password,
                post_name,
                to_ping,
                pinged,
                post_modified,
                post_modified_gmt,
                post_content_filtered,
                post_parent,
                guid,
                menu_order,
                post_type,
                post_mime_type,
                comment_count)
                VALUES 
                (null,1,?,?,?,?,'','publish','closed','closed','',?,'','',?,?,'',0,?,0,'post','',0)");

            $query->bindValue(1, $data);
            $query->bindValue(2, $data_gmt);
            $query->bindValue(3, $texto);
            $query->bindValue(4, $titulo);
            $query->bindValue(5, $slug);
            $query->bindValue(6, $data);
            $query->bindValue(7, $data_gmt);
            $query->bindValue(8, SITE . $slug);

            $query->execute();

            $post_id = $conDestino->lastInsertId();

            if ($post_id <= 0) {
                throw new Exception("Erro veio!");
            }

            copy("antigo/{$midia}", "novo/{$relacao_pasta}{$post_id}_{$midia}");

        }
    }

    $conDestino->commit();

} catch (\Exception $e) {
    $conDestino->rollBack();
    echo $e->getMessage();
} finally {
    unset($conOrigem);
    unset($conDestino);
}

function removeAcentos($string, $slug = false) {
    $string = strtolower($string);
    // Código ASCII das vogais
    $ascii['a'] = range(224, 230);
    $ascii['e'] = range(232, 235);
    $ascii['i'] = range(236, 239);
    $ascii['o'] = array_merge(range(242, 246), array(240, 248));
    $ascii['u'] = range(249, 252);
    // Código ASCII dos outros caracteres
    $ascii['b'] = array(223);
    $ascii['c'] = array(231);
    $ascii['d'] = array(208);
    $ascii['n'] = array(241);
    $ascii['y'] = array(253, 255);
    foreach ($ascii as $key => $item) {
        $acentos = '';
        foreach ($item AS $codigo) $acentos .= chr($codigo);
        $troca[$key] = '/[' . $acentos . ']/i';
    }
    $string = preg_replace(array_values($troca), array_keys($troca), $string);
    // Slug?
    if ($slug) {
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        // Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
    }
    return $string;
}


?>
