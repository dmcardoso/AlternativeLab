<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 29/10/2018
 * Time: 18:19
 */

$array = [2,3,4,5,6];

$novo_array = array_map(function($valor){
   return $valor * $valor * $valor;
}, $array);

echo "Original: <br>";
echo "<pre>";
print_r($array);
echo "</pre>";

echo "Após o map: <br>";
echo "<pre>";
print_r($novo_array);
echo "</pre>";

?>