<?php

header("Content-Type: text/html; charset=utf-8");

set_time_limit(5 * 60);

$conDestino = new PDO("mysql:dbname=cidade_ocidental_2018;host=localhost", "root", "1234", $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false));

$conOrigem = new PDO("mysql:dbname=cocidental;host=localhost", "root", "1234", $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false));

$sql = "SELECT
            p.ID AS id,
            p.post_date AS data,
            p.post_title AS titulo,
            p.post_content AS texto,
            t.term_id AS idcat,
            t.name AS categoria,
            p.post_content,
            p.ID
        FROM
            wordpress_posts p,
            wordpress_term_relationships r,
            wordpress_term_taxonomy x,
            wordpress_terms t
        WHERE
            p.ID = r.object_id
        AND r.term_taxonomy_id = x.term_taxonomy_id
        AND x.term_id = t.term_id
        AND x.taxonomy LIKE 'category'
        AND p.post_content like '%http://cidadeocidental.go.gov.br/portal/wp-content/uploads/%'
        ORDER BY p.ID ASC";
//$sql = "select * from institucional WHERE id = 303";

$stmt = $conOrigem->prepare($sql);
$stmt->execute();


$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//print_r($result);

$final = array();
$midiaList = array();

$contador = 0;

foreach ($result as $i => $noticia) {

//    echo highlight_string(strip_tags($noticia["post_content"], "<ul><li><p><b><section><div><u><br/><span><em><strong><table><tbody><tfoot><thead><tr><i><ol><td><img><img/>"));

    $quebraLink = "portal/wp-content/uploads";
    $txt = explode($quebraLink, $noticia["post_content"]);

    $pastaQuebrada = explode("/", $txt[1]);
    $pasta = $pastaQuebrada[1] . "/" . $pastaQuebrada[2] . "/";
    $nomeArquivo = explode('"',$pastaQuebrada[3]);
//    echo $nomeArquivo[0];


    foreach ($txt as $parte) {
        $a = explode('"', $parte);
//
        foreach ($a as $ii => $mid) {
            $midia = explode(".", strip_tags($mid));
            if (count($midia) == 2 && in_array(mb_strtolower($midia[1]), array("pdf", "rar", "xlsx", "docx", "zip", "doc", "xlsx"))) {
                $final[$i]['anexos'][] = $mid;
                echo $noticia['ID'] . "<br>";
                echo $mid . "<br>";
                $contador++;
            }
        }
    }

//
    $final[$i]['post'] = $noticia['id'];
}
//
//$anexos = array();
//
//$cont = 0;

//foreach ($final as $post) {
//
//    $idGaleria = 0;
//
//    if (!isset($post['galeria'])) {
//        $stmNewGal = $conDestino->prepare("INSERT INTO galerias (nome, formatos, protecao, max_img) VALUES (?,?,?,?)");
//        $stmNewGal->bindValue(1, "Galeria Páginas");
//        $stmNewGal->bindValue(2, "img|audio|video|outros");
//        $stmNewGal->bindValue(3, 1);
//        $stmNewGal->bindValue(4, 0);
//        $res = $stmNewGal->execute();
//
//        if ($res) {
//            $idGaleria = $conDestino->lastInsertId();
//
//            $stmt = $conDestino->prepare('UPDATE noticias SET galeria = :galeria WHERE id = :id');
//            $stmt->execute(array(
//                ':id'   => $post['post'],
//                ':galeria' => $idGaleria
//            ));
//
//            if($stmt->rowCount() > 0){
//                echo "Galeria adicionada a registro <br>";
//            }
//
//        } else {
//            throw new Exception("Falha ao criar Galeria");
//        }
//    }
//
//    if (isset($post['anexos']) && count($post['anexos']) > 0) {
//
//        foreach ($post['anexos'] as $anexo) {
//
//            $cont++;
//
//            $sql2 = "select * from arquivos where arquivo = '{$anexo}'";
//
//            $stmt = $conOrigem->prepare($sql2);
//            $stmt->execute();
//
//            $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
//
//            if (isset($post['galeria'])) {
//
//                if (file_exists("antigo/{$anexo}")) {
//                    //
//                    $midia = $anexo;
//                    $titulo = $result2['nome'];
//
//
//                    copy("antigo/{$anexo}", "midias/img/{$anexo}");
//
//                    $stmNewMd = $conDestino->prepare("INSERT INTO midias (user_id, midia, titulo, imagem, tipo) VALUES (?,?,?,?,?)");
//                    $stmNewMd->bindValue(1, 1000);
//                    $stmNewMd->bindValue(2, $midia);
//                    $stmNewMd->bindValue(3, $titulo);
//                    $stmNewMd->bindValue(4, "null");
//                    $stmNewMd->bindValue(5, "img");
//                    $resNewMd = $stmNewMd->execute();
//
//                    if ($resNewMd) {
//                        $stmMdUso = $conDestino->prepare("INSERT INTO midias_uso (galeria_id, midia_id) VALUES (?,?)");
//                        $stmMdUso->bindValue(1, $post['galeria']);
//                        $stmMdUso->bindValue(2, $conDestino->lastInsertId());
//                        $resMdUso = $stmMdUso->execute();
//
//                        if (!$resMdUso) {
//                            throw new Exception("Midia-uso não cadastrada!");
//                        }
//                    } else {
//                        throw new Exception("Midia não cadastrada!");
//                    }
//                }
//
//            } else {
//
//                if (file_exists("antigo/{$anexo}")) {
//                    //
//                    $midia = $anexo;
//                    $titulo = $result2['nome'];
//
//                    echo "GALERIA : {$idGaleria} ---- {$post['post']}<br>";
//
//
//                    copy("antigo/{$anexo}", "midias/img/{$anexo}");
//
//                    $stmNewMd = $conDestino->prepare("INSERT INTO midias (user_id, midia, titulo, imagem, tipo) VALUES (?,?,?,?,?)");
//                    $stmNewMd->bindValue(1, 1000);
//                    $stmNewMd->bindValue(2, $midia);
//                    $stmNewMd->bindValue(3, $titulo);
//                    $stmNewMd->bindValue(4, "null");
//                    $stmNewMd->bindValue(5, "img");
//                    $resNewMd = $stmNewMd->execute();
//
//                    if ($resNewMd) {
//                        $stmMdUso = $conDestino->prepare("INSERT INTO midias_uso (galeria_id, midia_id) VALUES (?,?)");
//                        $stmMdUso->bindValue(1, $idGaleria);
//                        $stmMdUso->bindValue(2, $conDestino->lastInsertId());
//                        $resMdUso = $stmMdUso->execute();
//
//                        if (!$resMdUso) {
//                            throw new Exception("Midia-uso não cadastrada!");
//                        }
//                    } else {
//                        throw new Exception("Midia não cadastrada!");
//                    }
//                }
//
//            }
//        }
//
//    }
//}

?>

