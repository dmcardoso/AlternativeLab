<?php

header("Content-Type: text/html; charset=utf-8");
mb_internal_encoding("UTF-8");

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

$dirNoticia = 10291;

try {
    $conDestino->beginTransaction();

    $relCat = array();

    $categorias = "SELECT * FROM not_categorias";

    $stmCatOr = $conOrigem->prepare($categorias);
    $stmCatOr->execute();

    $result = $stmCatOr->fetchAll(PDO::FETCH_ASSOC);

    if (!$result || count($result) <= 0) {
        throw new Exception("Nenhuma categoria selecionada");
    }

    foreach ($result as $cat) {
        $stmNewCat = $conDestino->prepare("INSERT INTO categorias (nome) VALUES (?)");
        //$stmNewCat->bindValue(1, "null");
        $stmNewCat->bindValue(1, $cat["nome"]);

        $resNewCat = $stmNewCat->execute();
        if ($resNewCat) {
            $relCat[$cat["id"]] = $conDestino->lastInsertId();
        } else {
            throw new Exception("Falha ao cadastrar categoria");
        }
    }


    $noticias = "SELECT * FROM not_dados";

    $stmNotOr = $conOrigem->prepare($noticias);
    $stmNotOr->execute();

    $result = $stmNotOr->fetchAll(PDO::FETCH_ASSOC);


    foreach ($result as $noticia) {

        $idGaleria = 0;
        $idNoticia = 0;

        $stmNewGal = $conDestino->prepare("INSERT INTO galerias (nome, formatos, protecao, max_img) VALUES (?,?,?,?)");
        $stmNewGal->bindValue(1, "Galeria Notícia");
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
        $idCapa = 44;
        if (file_exists("antigo/{$noticia["foto"]}") && $noticia['foto'] !== null) {

            $midia = $noticia["foto"];
            $titulo = "Capa - " . $noticia["titulo"];

            if (empty($noticia["data"]) || strlen($noticia["data"]) < 10) {
                $data = date("Y-m-d H:i:s");
            } else {
                $data = $noticia["data"] . " " . $noticia["hora"];
                $data = strtotime($data);
                $data = date('Y/m/d H:i:s', $data);
            }

            copy("antigo/{$noticia["foto"]}", "midias/img/{$noticia["foto"]}");

            $stmNewMd = $conDestino->prepare("INSERT INTO midias (user_id, midia, titulo, imagem, tipo, data) VALUES (?,?,?,?,?,?)");
            $stmNewMd->bindValue(1, 1000);
            $stmNewMd->bindValue(2, $midia);
            $stmNewMd->bindValue(3, $titulo);
            $stmNewMd->bindValue(4, "null");
            $stmNewMd->bindValue(5, "img");
            $stmNewMd->bindValue(6, $data);
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


        if ($noticia["data"] == null || $noticia["hora"] == null || empty($noticia["data"]) || strlen($noticia["data"]) < 10) {
            $data = date("Y-m-d H:i:s");
        } else {
            $data = $noticia["data"] . " " . $noticia["hora"];
            $data = strtotime($data);
            $data = date('Y/m/d H:i:s', $data);
        }

        try {
//            echo "<pre>";
//            var_dump($noticia);
//            die;
            $t = utf8_decode($noticia["titulo"]);
            $txt = utf8_decode($noticia["texto"]);
            $stmNewNot = $conDestino->prepare("INSERT INTO noticias (id, dir, titulo, texto, galeria, data, capa) VALUES (?,?,?,?,?,?,?)");
            $stmNewNot->bindValue(1, $noticia["id"]);
            $stmNewNot->bindValue(2, $dirNoticia);
            $stmNewNot->bindValue(3, $t);
            $stmNewNot->bindValue(4, strip_tags($txt, "<p><a><b><strong><br><img><iframe>"));
            $stmNewNot->bindValue(5, $idGaleria);
            $stmNewNot->bindValue(6, $data);
            $stmNewNot->bindValue(7, $idCapa);
            $resNot = $stmNewNot->execute();
        } catch (Exception $e) {
            echo "<br>Linha " . $noticia["id"] . " falhou, tentando sem utf8.<br><br>";

            try {
                $t = $noticia["titulo"];
                $txt = $noticia["texto"];
                try {
                    $t = mb_convert_encoding($noticia["titulo"], 'Windows-1252', 'UTF-8');
                    $txt = mb_convert_encoding($noticia["texto"], 'Windows-1252', 'UTF-8');

                } catch(Exception $e){}

                $stmNewNot = $conDestino->prepare("INSERT INTO noticias (id, dir, titulo, texto, galeria, data, capa) VALUES (?,?,?,?,?,?,?)");
                $stmNewNot->bindValue(1, $noticia["id"]);
                $stmNewNot->bindValue(2, $dirNoticia);
                $stmNewNot->bindValue(3, $t);
                $stmNewNot->bindValue(4, strip_tags($txt, "<p><a><b><strong><br><img><iframe>"));
                $stmNewNot->bindValue(5, $idGaleria);
                $stmNewNot->bindValue(6, $data);
                $stmNewNot->bindValue(7, $idCapa);
                $resNot = $stmNewNot->execute();
            } catch (Exception $e) {
                echo "<br>Linha " . $noticia["id"] . " falhou novamente.<br><br>" . $e . "<br><br>";

                $t = $noticia["titulo"];
                $txt = $noticia["texto"];
                echo $t;

                $stmNewNot = $conDestino->prepare("INSERT INTO noticias (id, dir, titulo, texto, galeria, data, capa) VALUES (?,?,?,?,?,?,?)");
                $stmNewNot->bindValue(1, $noticia["id"]);
                $stmNewNot->bindValue(2, $dirNoticia);
                $stmNewNot->bindValue(3, $t);
                $stmNewNot->bindValue(4, strip_tags($txt, "<p><a><b><strong><br><img><iframe>"));
                $stmNewNot->bindValue(5, $idGaleria);
                $stmNewNot->bindValue(6, $data);
                $stmNewNot->bindValue(7, $idCapa);
                $resNot = $stmNewNot->execute();
            }
        }

        $idCapa = 1197;

        if ($resNot) {
            $idNoticia = $noticia["id"];
        } else {
            throw new Exception("Falha ao criar Notícia");
        }

        $stmMidias = $conOrigem->prepare("SELECT * FROM not_anexos WHERE post=?");
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


    }

    $conDestino->commit();
} catch (Exception $e) {
    echo $e->getMessage();
    echo "<br /> Linha: " . $e->getLine();
    echo "<pre>";
    print_r($e->getTrace());
    echo "</pre>";
    $conDestino->rollBack();
}

