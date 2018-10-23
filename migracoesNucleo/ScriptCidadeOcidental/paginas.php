<?php

header("Content-Type: text/html; charset=utf-8");

set_time_limit(5 * 60);

$conOrigem = new PDO("mysql:dbname=cocidental;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

$conDestino = new PDO("mysql:dbname=cidade_ocidental_2018;host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

$dirNoticia = 10276;

try {
    $conDestino->beginTransaction();


    $paginas = "SELECT
	p.ID AS id,
	p.post_date AS DATA,
	p.post_title AS titulo,
	p.post_content AS texto
FROM
	wordpress_posts p
WHERE
 p.post_type LIKE 'page' 
ORDER BY
	p.ID ASC";

    $stmNotOr = $conOrigem->prepare($paginas);
    $stmNotOr->execute();

    $result = $stmNotOr->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $noticia) {

        $idGaleria = 0;
        $idNoticia = 0;
        $contador = 0;

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

        $stmNewNot = $conDestino->prepare("INSERT INTO paginas (dir, titulo, texto, galeria) VALUES (?,?,?,?)");
        $stmNewNot->bindValue(1, $dirNoticia);
        $stmNewNot->bindValue(2, $noticia["titulo"]);
        $stmNewNot->bindValue(3, strip_tags($noticia["texto"], "<ul><li><p><b><section><div><u><br/><span><em><strong><table><tbody><tfoot><thead><tr><i><ol><td><img><img/>"));
        $stmNewNot->bindValue(4, $idGaleria);
        $resNot = $stmNewNot->execute();

        if ($resNot) {
            $idNoticia = $conDestino->lastInsertId();
            try {
                $quebraLink = "portal/wp-content/uploads";
                if (strstr($noticia["texto"], $quebraLink) != false) {
                    $txt = explode($quebraLink, $noticia["texto"]);
                    $pastaQuebrada = explode("/", $txt[1]);
                    $pasta = "/" . $pastaQuebrada[1] . "/" . $pastaQuebrada[2] . "/";
                    foreach ($txt as $parte) {
                        $a = explode('"', $parte);
//
                        foreach ($a as $ii => $mid) {
                            $midia = explode(".", strip_tags($mid));
                            if (count($midia) == 2 && in_array(mb_strtolower($midia[1]), array("pdf", "rar", "xlsx", "docx", "zip", "doc", "xlsx"))) {
                                $anexo_nome = explode("/", $mid);
                                $anexo_link = "/" . $anexo_nome[1] . "/" . $anexo_nome[2] . "/";
                                $anexo_titulo = explode(".", $anexo_nome[3]);
                                $nome_anexo = md5($anexo_nome[3]) . "." . $anexo_titulo[1];
                                if(strstr($mid, "DOCO-e-Edi%C3%A7ao") != false || strstr($mid, "Edi%C3%A7%C3%A3o") != false){
                                    if(strstr($mid, "semanal") != false){
                                        $teste = explode("semanal", $mid);
                                        $nome_anexo = "DOCO-e-Ediçao-semanal" . $teste[1];
                                        $mid = $pasta . $nome_anexo;
                                        $nome_anexo = md5($nome_anexo) . "." . $anexo_titulo[1];
                                    }
                                    if(strstr($mid, "Especial") != false){
                                        $teste = explode("Especial", $mid);
                                        $nome_anexo = "DOCO-e-Ediçao-Especial" . $teste[1];
                                        $mid = $pasta . $nome_anexo;
                                        $nome_anexo = md5($nome_anexo) . "." . $anexo_titulo[1];
                                    }
                                }
                                if(strstr($mid, "MAR%C3%87O") != false){
                                    if(strstr($mid, "Especial") != false){
                                        $teste = explode("Especial", $mid);
                                        $nome_anexo = "DOCO-e-Ediçao-Especial";
                                        $complemento = explode("de-", $teste[1]);
                                        $nome_anexo .= $complemento[0] . "de-MARÇO." . $anexo_titulo[1];
                                        $mid = $pasta . $nome_anexo;
                                        $nome_anexo = md5($nome_anexo) . "." . $anexo_titulo[1];
                                    }
                                }
                                echo "$nome_anexo" . "<br>";
                                echo "$mid" . "<br>";
                                copy("antigo" . utf8_decode($mid), "midias/outros/{$nome_anexo}");
                                try {
                                    $stmNewMd = $conDestino->prepare("INSERT INTO midias (user_id, midia, titulo, imagem, tipo, data) VALUES (?,?,?,?,?,?)");
                                    $stmNewMd->bindValue(1, 1000);
                                    $stmNewMd->bindValue(2, $nome_anexo);
                                    $stmNewMd->bindValue(3, $anexo_titulo[0]);
                                    $stmNewMd->bindValue(4, "null");
                                    $stmNewMd->bindValue(5, "outros");
                                    $stmNewMd->bindValue(6, null);
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
                                } catch (Exception $ex) {
                                    throw new Exception("Falha ao criar mídia" . $ex->getMessage());
                                }
                            }
                        }
                    }
                }
            } catch (Exception $ex) {
                throw new Exception("Falha ao criar midias dos links" . $ex->getMessage());
            }
        } else {
            throw new Exception("Falha ao criar Página");
        }

        $stmMidias = $conOrigem->prepare("SELECT
                                                        post_date AS data,
                                                        post_title AS titulo,
                                                        guid AS link,
                                                        post_mime_type AS tipo
                                                    FROM
                                                        wordpress_posts
                                                    WHERE
                                                        post_parent = ?
                                                    AND post_type LIKE 'attachment'");
        $stmMidias->bindValue(1, $noticia["id"]);
        $stmMidias->execute();

        $midias = $stmMidias->fetchAll(PDO::FETCH_ASSOC);

        foreach ($midias as $mid) {

            $link = explode("uploads", $mid["link"]);

            if (isset($link[1]) && ($mid["tipo"] == "image/jpeg" || $mid["tipo"] == "image/png" || $mid["tipo"] == "image/jpg")) {
                $anexo_link = $link[1];
                $nome = explode("/", $link[1]);
                $anexo_nome = utf8_decode(end($nome));

                $ext = explode(".", $anexo_nome);
                $anexo_nome = md5($anexo_nome . time()) . "." . strtolower(end($ext));

                copy("antigo" . utf8_decode($anexo_link), "midias/img/{$anexo_nome}");

                $stmNewMd = $conDestino->prepare("INSERT INTO midias (user_id, midia, titulo, imagem, tipo, data) VALUES (?,?,?,?,?,?)");
                $stmNewMd->bindValue(1, 1000);
                $stmNewMd->bindValue(2, $anexo_nome);
                $stmNewMd->bindValue(3, $mid["titulo"]);
                $stmNewMd->bindValue(4, "null");
                $stmNewMd->bindValue(5, "img");
                $stmNewMd->bindValue(6, $mid["data"]);
                $resNewMd = $stmNewMd->execute();

                if ($resNewMd) {
                    $stmMdUso = $conDestino->prepare("INSERT INTO midias_uso (galeria_id, midia_id) VALUES (?,?)");
                    $stmMdUso->bindValue(1, $idGaleria);
                    $stmMdUso->bindValue(2, $conDestino->lastInsertId());
                    $resMdUso = $stmMdUso->execute();

                    if (!$resMdUso) {
                        throw new Exception("Midia-uso não cadastrada!");
                    } else {
                        $idMidiaUso = $conDestino->lastInsertId();
                        if ($contador == 0) {
                            $fotoCapa = $conDestino->prepare("UPDATE paginas set capa = ? where id = ?");
                            $fotoCapa->bindValue(1, $idMidiaUso);
                            $fotoCapa->bindValue(2, $idNoticia);
                            $fotocapaInserida = $fotoCapa->execute();
                            $contador++;
                        }
                    }
                } else {
                    throw new Exception("Midia não cadastrada!");
                }
            } elseif (isset($link[1]) && ($mid["tipo"] == "application/pdf" || $mid["tipo"] == "application/msword" || $mid["tipo"] == "application/vnd.ms-exce" || $mid["tipo"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $mid["tipo"] == "application/rar" || $mid["tipo"] == "application/rtf")) {
                $anexo_link = $link[1];
                $nome = explode("/", $link[1]);
                $anexo_nome = utf8_decode(end($nome));

                $ext = explode(".", $anexo_nome);
                $anexo_nome = md5($anexo_nome . time()) . "." . strtolower(end($ext));

                copy("antigo" . utf8_decode($anexo_link), "midias/outros/{$anexo_nome}");

                $stmNewMd = $conDestino->prepare("INSERT INTO midias (user_id, midia, titulo, imagem, tipo, data) VALUES (?,?,?,?,?,?)");
                $stmNewMd->bindValue(1, 1000);
                $stmNewMd->bindValue(2, $anexo_nome);
                $stmNewMd->bindValue(3, $mid["titulo"]);
                $stmNewMd->bindValue(4, "null");
                $stmNewMd->bindValue(5, "outros");
                $stmNewMd->bindValue(6, $mid["data"]);
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

/*
echo "<pre>";

foreach ($result as $linha) {


    echo "<br /><b>ID:</b> " . $linha["ID"];
    echo "<br /><b>TÍTULO</b> " . $linha["post_title"];
    echo "<br /><b>DATA:</b> " . $linha["post_date"];
    echo "<br /><b>CONTEÚDO:</b> " . strip_tags($linha["post_content"]);
    echo "<br />";
    echo "<br />";

    print_r($linha);
    echo "<br />";

    $stmSon = $conDestino->prepare("SELECT * FROM wp_posts WHERE post_parent={$linha["ID"]} ORDER BY ID DESC limit 0, 100");
    $stmSon->execute();

    $subRes = $stmSon->fetchAll(PDO::FETCH_ASSOC);

    foreach ($subRes as $filho) {

        print_r($linha);
    }

    echo "<br /><hr /><br />";

}

echo "</pre>";
*/
