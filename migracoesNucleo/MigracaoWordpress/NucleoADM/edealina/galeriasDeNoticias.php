<?php

date_default_timezone_set("America/Sao_Paulo");
header("Content-Type: text/html; charset=utf-8");
mb_internal_encoding("UTF-8");

set_time_limit(5 * 60);

require './config.php';

$conOrigem = new PDO("mysql:dbname=" . BD_ORIGEM . ";host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));


try {
    $conOrigem->beginTransaction();

    $stmt = $conOrigem->prepare('SELECT
    n.id,
		n.titulo,
       n.galeria,
    ( SELECT count( * ) FROM midias_uso mu WHERE mu.galeria_id = n.galeria ) AS galerias
FROM
    noticias n
		WHERE ( SELECT count( * ) FROM midias_uso mu WHERE mu.galeria_id = n.galeria ) > 0');

    $noticias = $stmt->execute();
    $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($noticias as $i => $v) {

        $id = $v['id'];
        $titulo = $v['titulo'];
        $galeria = $v['galeria'];
        $galerias = $v['galerias'];

        $newStmt = $conOrigem->prepare('select midia from midias_uso mu inner join midias m on mu.midia_id = m.id where mu.galeria_id = ' . $galeria);

        $galerias = $newStmt->execute();
        $galerias = $newStmt->fetchAll(PDO::FETCH_ASSOC);

        if(!is_dir('novo\\' . $titulo)){
            mkdir('novo\\' . $titulo);
        }

        foreach ($galerias as $ii => $vv) {
            $img = $vv['midia'];

            copy('antigo\\' . $img, 'novo\\' . $titulo . '\\' . $img);
        }
    }

    $conOrigem->commit();
} catch (\Exception $e) {
    echo $e->getMessage();
} finally {
    unset($conOrigem);
}