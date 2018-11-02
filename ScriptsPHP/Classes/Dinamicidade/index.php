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
$dinamic->setNome("Daniel");
$dinamic->setSobreNomeDoPai("Moreira");

$dinamic2 = new Dinamicidade();

$dinamic2->setAvo("Augusto");
$dinamic->setPai($dinamic2);

$dinamic3 = new Dinamicidade();
$dinamic3->setFeijao('arroz');
$dinamic2->setRefeicao($dinamic3);


echo $dinamic->getNome() . "<br>";
echo $dinamic->getValor() . "<br>";
echo $dinamic->getSobreNomeDoPai() . "<br>";
echo $dinamic->getPai()->getAvo() . "<br>";


echo $dinamic->camelToStr("meuNome") ."<br>";
echo $dinamic->camelToAttr("meuNome") . "<br>";
echo $dinamic->attrToCamel("meu_nome");
echo "<pre>";
print_r($dinamic);


//echo $dinamic->nome;
//$valor = $dinamic->getValor();

//echo $valor . "<<<";

//print_r($dinamic);

$dados = [
    "nome" => "Daniel",
    "sobre_nome" => "Moreira Cardoso",
    "data_nascimento" => "06/01/1999"
];
$final = new Dinamicidade($dados);

print_r($final);

echo $final->getNome() . "<br>";
echo $final->getSobreNome() . "<br>";
echo $final->getDataNascimento() . "<br>";
?>