<?php

header("Content-Type: text/html; charset=utf-8");

set_time_limit(5 * 60);

$conOrigem = new PDO("mysql:dbname=camara_rubiataba_antigo;host=localhost", "root", "", $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false));

$conDestino = new PDO("mysql:dbname=camara_rubiataba2018;host=localhost", "root", "", $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false));

$dirNoticia = 10277;

$noticias = "SELECT * FROM albuns";

$stmNotOr = $conOrigem->prepare($noticias);
$stmNotOr->execute();

$result = $stmNotOr->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $noticia) {

    $idGaleria = 0;
//    $idNoticia = 0;

    $stmNewGal = $conDestino->prepare("INSERT INTO galerias (id, nome, formatos, protecao, max_img) VALUES (?,?,?,?,?)");
    $stmNewGal->bindValue(1, $noticia['id']);
    $stmNewGal->bindValue(2, substr($noticia['nome'], 0, 100));
    $stmNewGal->bindValue(3, "img");
    $stmNewGal->bindValue(4, 0);
    $stmNewGal->bindValue(5, 0);
    $res = $stmNewGal->execute();

    if ($res) {
        $idGaleria = $conDestino->lastInsertId();
        echo "Galeria criada {$idGaleria}<br>";
    } else {
        throw new Exception("Falha ao criar Galeria");
    }


    $fotos = "SELECT * FROM fotos WHERE album ={$noticia['id']}";

    $stmFotos = $conOrigem->prepare($fotos);
    $stmFotos->execute();

    $result_fotos = $stmFotos->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result_fotos as $midia) {

        //Imagem Capa
        $idCapa = 1323;
        if (file_exists("antigo/{$midia["nome"]}")) {

            if (!empty($midia['descricao'])) {
                $titulo = "Capa - " . $midia['descricao'];
            }else{
                $titulo = '';
            }

            copy("antigo/{$midia["nome"]}", "midias/img/{$midia["nome"]}");

            $stmNewMd = $conDestino->prepare("INSERT INTO midias (user_id, midia, titulo, imagem, tipo) VALUES (?,?,?,?,?)");
            $stmNewMd->bindValue(1, 1000);
            $stmNewMd->bindValue(2, $midia["nome"]);
            $stmNewMd->bindValue(3, $titulo);
            $stmNewMd->bindValue(4, "null");
            $stmNewMd->bindValue(5, "img");
            $resNewMd = $stmNewMd->execute();

            if ($resNewMd) {
                $stmMdUso = $conDestino->prepare("INSERT INTO midias_uso (galeria_id, midia_id) VALUES (?, ?)");
                $stmMdUso->bindValue(1, $noticia["id"]);
                $stmMdUso->bindValue(2, $conDestino->lastInsertId());
                $resMdUso = $stmMdUso->execute();

                if (!$resMdUso) {
                    throw new Exception("Midia-uso não cadastrada!");
                }

                $idCapa = $conDestino->lastInsertId();

            } else {
                throw new Exception("Midia não cadastrada!");
            }
        }
    }
}