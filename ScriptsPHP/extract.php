<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 26/10/2018
 * Time: 09:12
 */

//$indice = 'batata';

$array = [
    'indice' => ['ola' => 'daniel', "bom dia" => "aliberto"],
    'segundo' => 2,
    'terceiro' => "ola",
];

//Não funciona

//
//foreach ($array as $i => $v){
//    if(isset($i)){
//        echo "Variável {$i} já existe";
//    }
//}



//EXTR_OVERWRITE sobrescreve tudo
//EXTR_SKIP não sobrescreve
$quantidade = extract($array, EXTR_SKIP);

echo count($array) . "<br>";
echo $quantidade . "<br>";
echo "<pre>";
print_r($array);
echo "<br>";
print_r($indice);
echo "<br>";
print_r($segundo);
echo "<br>";
print_r($terceiro);

echo "<pre>";
unset($array);

//Array não existe mas as variáveis criadas, sim
print_r($array);
echo "<br>";
print_r($indice);
echo "<br>";
print_r($segundo);
echo "<br>";
print_r($terceiro);






?>