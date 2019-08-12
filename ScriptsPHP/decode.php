<?php

set_time_limit(5 * 60);

$conDestino = new PDO("mysql:dbname=camara_rubiataba2018;host=localhost", "root", "", $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false));

$sql = "SELECT * FROM noticias";
$result = $conDestino->query($sql);
$rows = $result->fetchAll();

print_r($rows);
//
//foreach ($rows as $v) {
//
//        $v['texto'] = html_entity_decode($v['texto'], ENT_QUOTES, "UTF-8");
//
//        try {
//
//            $stmt = $conDestino->prepare('UPDATE noticias SET texto = :texto WHERE id = :id');
//            $stmt->execute(array(':id' => $v['id'], ':texto' => $v['texto']));
//
//            echo $stmt->rowCount();
//        } catch (PDOException $e) {
//            echo 'Error: ' . $e->getMessage();
//            echo "<br> id: >>>>>>" . $v['id'] . '<<<<<<<br>';
//        }
//}