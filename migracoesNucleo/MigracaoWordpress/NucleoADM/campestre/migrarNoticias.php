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

require './config.php';

$conOrigem = new PDO("mysql:dbname=" . BD_ORIGEM . ";host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

$conDestino = new PDO("mysql:dbname=" . BD_DESTINO . ";host=localhost", "root", "1234", $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => false
));

// ALTERAR PARA USAR NO CAMPO GUID QUE É O DOMÍNIO DO SITE
const SITE = "http://192.168.254.222/NucleoWeb/wordpress/";
const ARQUIVOS = SITE . "wp-content/uploads/";

try {
    $conDestino->beginTransaction();

    // Deleta as categorias existentes
    $query_categorias_existentes = $conDestino->prepare('SELECT term_id FROM ' . PREFIXO_TABLE . 'term_taxonomy WHERE taxonomy = "category"');
    $categories_delete = $query_categorias_existentes->execute();
    $categories_delete = $query_categorias_existentes->fetchAll(PDO::FETCH_ASSOC);
    $categories_delete_ids = [];

    foreach ($categories_delete as $idx => $v) {
        $categories_delete_ids[] = $v['term_id'];
    }

    if (count($categories_delete_ids) > 0) {
        $categories_delete_ids = implode(',', $categories_delete_ids);

        $delete_categories_query = $conDestino->prepare('DELETE FROM ' . PREFIXO_TABLE . 'term_taxonomy where term_id in (' . $categories_delete_ids . ')');
        $delete_categories_terms_query = $conDestino->prepare('DELETE FROM ' . PREFIXO_TABLE . 'terms where term_id in (' . $categories_delete_ids . ')');

        $delete_categories_query->execute();
        $delete_categories_terms_query->execute();
    }


    // Pega as categorias cadastradas no banco e insere uma a uma para pegar a relação dos ids
    $query_categorias = $conOrigem->prepare('SELECT * FROM categorias');

    $query_categorias->execute();

    $result = $query_categorias->fetchAll(PDO::FETCH_ASSOC);

    $categories = [];
    foreach ($result as $idx => $category) {
        try {
            $query_insert_categories = $conDestino->prepare('INSERT INTO ' . PREFIXO_TABLE . 'terms (name,slug,term_group) values(?,?,0)');

            $query_insert_categories->bindValue(1, $category['nome']);
            $query_insert_categories->bindValue(2, removeAcentos($category['nome'], true));

            $query_insert_categories->execute();

            $query_insert_categories_taxonomy = $conDestino->prepare('INSERT INTO ' . PREFIXO_TABLE . 'term_taxonomy (term_id,taxonomy,description, parent, count) values(?,?,?,0,0)');
            $query_insert_categories_taxonomy->bindValue(1, $conDestino->lastInsertId());
            $query_insert_categories_taxonomy->bindValue(2, 'category');
            $query_insert_categories_taxonomy->bindValue(3, '');

            $query_insert_categories_taxonomy->execute();

            $categories[] = [
                'before' => $category['id'],
                'now' => $conDestino->lastInsertId()
            ];

        } catch (\Exception $e) {
            echo "erro nas categorias";
            throw new Exception('AQUI ' . $e);
        }
    }


    $query = $conOrigem->prepare("
        SELECT
            n.data,
            n.texto,
            n.titulo,
            n.categoria,
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
//            $mimtype = mime_content_type("antigo/" . $midia);

            $ano_publicacao = explode("-", $data)[0];
            $mes_publicacao = explode("-", $data)[1];

            if (!is_dir(__DIR__ . "\\novo\\" . $ano_publicacao)) {
                mkdir(__DIR__ . "\\novo\\" . $ano_publicacao);
            }

//            echo "{$ano_publicacao}/{$mes_publicacao}<br>";
            if (!is_dir(__DIR__ . "\\novo\\" . $ano_publicacao . '\\' . $mes_publicacao)) {
                mkdir(__DIR__ . "\\novo\\" . $ano_publicacao . '\\' . $mes_publicacao);
            }

            $relacao_pasta = $ano_publicacao . '/' . explode("-", $data)[1] . "/";


            $query = $conDestino->prepare("INSERT INTO " . PREFIXO_TABLE . "posts 
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
            } else {

                foreach ($categories as $idx => $val) {
                    if (intval($val['before']) == $v['categoria']) {
                        $query_insert_categories_relation = $conDestino->prepare('INSERT INTO ' . PREFIXO_TABLE . 'term_relationships (object_id,term_taxonomy_id) values(?,?)');
                        $query_insert_categories_relation->bindValue(1, $post_id);
                        $query_insert_categories_relation->bindValue(2, $val['now']);

                        $query_insert_categories_relation->execute();
                    }
                }
            }

            $ext = mb_strtolower(explode('.', $midia)[1]);
            $midia_nova = md5($midia);

            copy("antigo/{$midia}", "novo/{$relacao_pasta}{$post_id}_{$midia_nova}.{$ext}");

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
