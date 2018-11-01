<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 01/11/2018
 * Time: 16:06
 */

require 'Dinamicidade.class.php';

$dinamic = new Dinamicidade();

$dinamic->setValor(15);
$dinamic->setNome("Daniek");
$dinamic->setSobreNome("Moreira");

echo $dinamic->getNome() . "<br>";
echo $dinamic->getValor() . "<br>";
echo $dinamic->getSobreNome();

//echo $dinamic->nome;
$valor = $dinamic->getValor();

//echo $valor . "<<<";

//print_r($dinamic);

?>