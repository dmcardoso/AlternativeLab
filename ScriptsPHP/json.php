<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 05/11/2018
 * Time: 16:43
 */

$array = ["nome" => "Daniel", "atributos" => ["idade" => 19, "educacao" => "nenhuma"], "sexo" => "M"];

//Transforma em json
$json = json_encode($array);

//Volta para array
$array_de_novo = json_decode($json);

echo "<pre>";
print_r($array);
print_r($json);
echo "<br>";
print_r($array_de_novo);
echo "</pre>";
?>