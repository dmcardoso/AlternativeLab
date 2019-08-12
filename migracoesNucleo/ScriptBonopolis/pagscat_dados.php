<?php

header("Content-Type: text/html; charset=utf-8");

set_time_limit(5 * 60);

$conOrigem = new PDO("mysql:dbname=prefeitura_bonopolis_antigo;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

$conDestino = new PDO("mysql:dbname=prefeitura_bonopolis;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

$dirNoticia = 10290;

$noticias = "SELECT * FROM pgsdepart_dados";

$stmNotOr = $conOrigem->prepare($noticias);
$stmNotOr->execute();

$result = $stmNotOr->fetchAll(PDO::FETCH_ASSOC);
//echo "<pre>";
$cont = 0;

foreach ($result as $noticia) {
    echo $cont . "<br>";
    $idGaleria = 0;
    $idNoticia = 0;

    $stmNewGal = $conDestino->prepare("INSERT INTO galerias (nome, formatos, protecao, max_img) VALUES (?,?,?,?)");
    $stmNewGal->bindValue(1, "Galeria Institucional");
    $stmNewGal->bindValue(2, "img|audio|video|outros");
    $stmNewGal->bindValue(3, 1);
    $stmNewGal->bindValue(4, 0);
    $res = $stmNewGal->execute();

    if ($res) {
        $idGaleria = $conDestino->lastInsertId();
    } else {
        throw new Exception("Falha ao criar Galeria");
    }

//    var_dump($noticia);

    //Imagem Capa
    $idCapa = 1331;
    if (file_exists("antigo/{$noticia["foto"]}") && $noticia["foto"] !== null) {

        $midia = $noticia["foto"];
        $titulo = "Capa - " . $noticia["titulo"];
        $titulo = "Capa - " . $noticia["titulo"];

        echo $noticia['foto'];

        copy("antigo/{$noticia["foto"]}", "midias/img/{$noticia["foto"]}");

        $stmNewMd = $conDestino->prepare("INSERT INTO midias (user_id, midia, titulo, imagem, tipo) VALUES (?,?,?,?,?)");
        $stmNewMd->bindValue(1, 1000);
        $stmNewMd->bindValue(2, $midia);
        $stmNewMd->bindValue(3, $titulo);
        $stmNewMd->bindValue(4, "null");
        $stmNewMd->bindValue(5, "img");
        $resNewMd = $stmNewMd->execute();

        if ($resNewMd) {
            $stmMdUso = $conDestino->prepare("INSERT INTO midias_uso (galeria_id, midia_id) VALUES (NULL, ?)");
            //$stmMdUso->bindValue(1,$idGaleria);
            $stmMdUso->bindValue(1, $conDestino->lastInsertId());
            $resMdUso = $stmMdUso->execute();

            if (!$resMdUso) {
                throw new Exception("Midia-uso não cadastrada!");
            }

            $idCapa = $conDestino->lastInsertId();

        } else {
            throw new Exception("Midia não cadastrada!");
        }

    }

    $stmNewNot = $conDestino->prepare("INSERT INTO departamento (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
    $stmNewNot->bindValue(1, $dirNoticia);
    $stmNewNot->bindValue(2, $noticia["titulo"]);
    $stmNewNot->bindValue(3, strip_tags($noticia["texto"], "<p><a><b><strong><br>"));
    $stmNewNot->bindValue(4, $idGaleria);
    $stmNewNot->bindValue(5, $idCapa);
    $resNot = $stmNewNot->execute();

    if ($resNot) {
        $idNoticia = $conDestino->lastInsertId();
    } else {
        throw new Exception("Falha ao criar página");
    }

    $stmMidias = $conOrigem->prepare("SELECT * FROM pgscat_anexos WHERE post=?");
    $stmMidias->bindValue(1, $noticia["id"]);
    $stmMidias->execute();

    $midias = $stmMidias->fetchAll(PDO::FETCH_ASSOC);

    foreach ($midias as $mid) {

        if (file_exists("antigo/{$mid["anexo"]}")) {

            $midia = $mid["anexo"];
            $titulo = $mid["id"] . " - " . $noticia["titulo"];

            if ($noticia["data"] == null || $noticia["hora"] == null || empty($noticia["data"]) || strlen($noticia["data"]) < 10) {
                $data = date("Y-m-d H:i:s");
            } else {
                $data = $noticia["data"] . " " . $noticia["hora"];
                $data = strtotime($data);
                $data = date('Y/m/d H:i:s', $data);
            }

            copy("antigo/{$mid["anexo"]}", "midias/img/{$mid["anexo"]}");

            $stmNewMd = $conDestino->prepare("INSERT INTO midias (user_id, midia, titulo, imagem, tipo, data) VALUES (?,?,?,?,?,?)");
            $stmNewMd->bindValue(1, 1000);
            $stmNewMd->bindValue(2, $midia);
            $stmNewMd->bindValue(3, $titulo);
            $stmNewMd->bindValue(4, "null");
            $stmNewMd->bindValue(5, "img");
            $stmNewMd->bindValue(6, $data);
            $resNewMd = $stmNewMd->execute();

            if ($resNewMd) {
                $stmMdUso = $conDestino->prepare("INSERT INTO midias_uso (galeria_id, midia_id) VALUES (?,?)");
                $stmMdUso->bindValue(1, $idGaleria);
                $stmMdUso->bindValue(2, $conDestino->lastInsertId());
                $resMdUso = $stmMdUso->execute();

                if (!$resMdUso) {
                    throw new Exception("Midia-uso não cadastrada!");
                }
            } else {
                throw new Exception("Midia não cadastrada!");
            }
        }
    }


    $idCapa = 1331;

    $cont++;
}