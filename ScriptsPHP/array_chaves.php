<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 29/10/2018
 * Time: 18:13
 */

$array = ["chave_1" => 0, "chave_2" => 1, "chave_3" => 2, "chave_4" => 3];

// verifica se o valor
$resultado = in_array("0", $array);

echo $resultado . "<br>";

// verifica se a chave existe
$resultado = in_array("chave_1", array_keys($array));

echo $resultado . "<br>";

$lastPosition = end($array);
echo $lastPosition . "<br>";
$chaves = array_keys($array);
$lastkey = end($chaves);
echo $lastkey;

?>