<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 05/10/2018
 * Time: 14:53
 */

date_default_timezone_set('America/Sao_Paulo');

$data = date("Y-m-d H:i:s");
$timestamp = strtotime($data) + (3 * (60*60));
$dataHora = strftime('%Y-%m-%d %H:%M:%S', $timestamp);

echo $data . "<br>";

echo $dataHora . "<br>";


$relacao = explode("-", explode(" ", $data)[0])[0] . '/' . explode("-", explode(" ", $data)[0])[1] . "/";
echo $relacao;


?>