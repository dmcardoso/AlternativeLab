<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 06/02/2019
 * Time: 10:21
 */

$frutas = array("d" => "limao", "a" => "laranja", "b" => "banana", "c" => "melancia");
arsort($frutas);
foreach ($frutas as $chave => $valor) {
    echo "{$chave} = {$valor} <br>";
}

echo "-------------------------";
$frutas = array("d" => "limao", "a" => "laranja", "b" => "banana", "c" => "melancia");
asort($frutas);
foreach ($frutas as $chave => $valor) {
    echo "{$chave} = {$valor} <br>";
}