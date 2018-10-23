<?php

header("Content-Type: text/html; charset=utf-8");
mb_internal_encoding("UTF-8");

set_time_limit(5 * 60);

$conOrigem = new PDO("mysql:dbname=camara_mozarlandia_antigo;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

$conDestino = new PDO("mysql:dbname=camara_mozarlandia_2018;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

$dirCamara = 10283;
$dirCidade = 10276;
$dirComissao = 10280;
$dirVereador = 10282;

$paginas = "SELECT * FROM mo_pgs";

$stmNotOr = $conOrigem->prepare($paginas);
$stmNotOr->execute();

$result = $stmNotOr->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $noticia) {

    if ($noticia['cat'] == 1) {

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

        //Imagem Capa
        $idCapa = 217;
        if (file_exists("antigo/{$noticia["foto"]}")) {

            $midia = $noticia["foto"];
            $titulo = "Capa - " . $noticia["titulo"];
            $titulo = "Capa - " . $noticia["titulo"];

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

        try {
            $t = utf8_decode($noticia["titulo"]);
            $txt = utf8_decode($noticia["texto"]);
            $stmNewNot = $conDestino->prepare("INSERT INTO vereadores (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
            $stmNewNot->bindValue(1, $dirVereador);
            $stmNewNot->bindValue(2, $t);
            $stmNewNot->bindValue(3, strip_tags($txt, "<p><a><b><strong><br>"));
            $stmNewNot->bindValue(4, $idGaleria);
            $stmNewNot->bindValue(5, $idCapa);
            $resNot = $stmNewNot->execute();
        } catch (Exception $e) {
            echo "<br>Linha " . $noticia["id"] . " falhou, tentando sem utf8.<br><br>";
            try {
                $t = mb_convert_encoding($noticia["titulo"], 'Windows-1252', 'UTF-8');
                $txt = mb_convert_encoding($noticia["texto"], 'Windows-1252', 'UTF-8');
                $stmNewNot = $conDestino->prepare("INSERT INTO vereadores (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
                $stmNewNot->bindValue(1, $dirVereador);
                $stmNewNot->bindValue(2, $t);
                $stmNewNot->bindValue(3, strip_tags($txt, "<p><a><b><strong><br>"));
                $stmNewNot->bindValue(4, $idGaleria);
                $stmNewNot->bindValue(5, $idCapa);
                $resNot = $stmNewNot->execute();
            } catch (Exception $ex) {
                $t = $noticia["titulo"];
                $txt = $noticia["texto"];
                $stmNewNot = $conDestino->prepare("INSERT INTO vereadores (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
                $stmNewNot->bindValue(1, $dirVereador);
                $stmNewNot->bindValue(2, $t);
                $stmNewNot->bindValue(3, strip_tags($txt, "<p><a><b><strong><br>"));
                $stmNewNot->bindValue(4, $idGaleria);
                $stmNewNot->bindValue(5, $idCapa);
                $resNot = $stmNewNot->execute();
            }
        }


        $idCapa = 217;
    }

    if ($noticia['cat'] == 4) {

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

        //Imagem Capa
        $idCapa = 218;
        if (file_exists("antigo/{$noticia["foto"]}")) {

            $midia = $noticia["foto"];
            $titulo = "Capa - " . $noticia["titulo"];
            $titulo = "Capa - " . $noticia["titulo"];

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

        try {
            $t = utf8_decode($noticia["titulo"]);
            $txt = utf8_decode($noticia["texto"]);
            $stmNewNot = $conDestino->prepare("INSERT INTO paginas (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
            $stmNewNot->bindValue(1, $dirCamara);
            $stmNewNot->bindValue(2, $t);
            $stmNewNot->bindValue(3, strip_tags($txt, "<p><a><b><strong><br>"));
            $stmNewNot->bindValue(4, $idGaleria);
            $stmNewNot->bindValue(5, $idCapa);
            $resNot = $stmNewNot->execute();
        } catch (Exception $e) {
            echo "<br>Linha " . $noticia["id"] . " falhou, tentando sem utf8.<br><br>";
            try {
                $t = mb_convert_encoding($noticia["titulo"], 'Windows-1252', 'UTF-8');
                $txt = mb_convert_encoding($noticia["texto"], 'Windows-1252', 'UTF-8');
                $stmNewNot = $conDestino->prepare("INSERT INTO paginas (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
                $stmNewNot->bindValue(1, $dirCamara);
                $stmNewNot->bindValue(2, $t);
                $stmNewNot->bindValue(3, strip_tags($txt, "<p><a><b><strong><br>"));
                $stmNewNot->bindValue(4, $idGaleria);
                $stmNewNot->bindValue(5, $idCapa);
                $resNot = $stmNewNot->execute();
            } catch (Exception $ex) {
                $t = $noticia["titulo"];
                $txt = $noticia["texto"];
                $stmNewNot = $conDestino->prepare("INSERT INTO paginas (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
                $stmNewNot->bindValue(1, $dirCamara);
                $stmNewNot->bindValue(2, $t);
                $stmNewNot->bindValue(3, strip_tags($txt, "<p><a><b><strong><br>"));
                $stmNewNot->bindValue(4, $idGaleria);
                $stmNewNot->bindValue(5, $idCapa);
                $resNot = $stmNewNot->execute();
            }
        }

        $idCapa = 218;
    }

    if ($noticia['cat'] == 3) {

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

        //Imagem Capa
        $idCapa = 219;
        if (file_exists("antigo/{$noticia["foto"]}")) {

            $midia = $noticia["foto"];
            $titulo = "Capa - " . $noticia["titulo"];
            $titulo = "Capa - " . $noticia["titulo"];

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

        try {
            $t = utf8_decode($noticia["titulo"]);
            $txt = utf8_decode($noticia["texto"]);
            $stmNewNot = $conDestino->prepare("INSERT INTO comissao (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
            $stmNewNot->bindValue(1, $dirComissao);
            $stmNewNot->bindValue(2, $t);
            $stmNewNot->bindValue(3, strip_tags($txt, "<p><a><b><strong><br>"));
            $stmNewNot->bindValue(4, $idGaleria);
            $stmNewNot->bindValue(5, $idCapa);
            $resNot = $stmNewNot->execute();
        } catch (Exception $e) {
            echo "<br>Linha " . $noticia["id"] . " falhou, tentando sem utf8.<br><br>";
            try {
                $t = mb_convert_encoding($noticia["titulo"], 'Windows-1252', 'UTF-8');
                $txt = mb_convert_encoding($noticia["texto"], 'Windows-1252', 'UTF-8');
                $stmNewNot = $conDestino->prepare("INSERT INTO comissao (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
                $stmNewNot->bindValue(1, $dirComissao);
                $stmNewNot->bindValue(2, $t);
                $stmNewNot->bindValue(3, strip_tags($txt, "<p><a><b><strong><br>"));
                $stmNewNot->bindValue(4, $idGaleria);
                $stmNewNot->bindValue(5, $idCapa);
                $resNot = $stmNewNot->execute();
            } catch (Exception $ex) {
                $t = $noticia["titulo"];
                $txt = $noticia["texto"];
                $stmNewNot = $conDestino->prepare("INSERT INTO comissao (dir, titulo, texto, galeria, capa) VALUES (?,?,?,?,?)");
                $stmNewNot->bindValue(1, $dirComissao);
                $stmNewNot->bindValue(2, $t);
                $stmNewNot->bindValue(3, strip_tags($txt, "<p><a><b><strong><br>"));
                $stmNewNot->bindValue(4, $idGaleria);
                $stmNewNot->bindValue(5, $idCapa);
                $resNot = $stmNewNot->execute();
            }
        }

        $idCapa = 219;
    }


}