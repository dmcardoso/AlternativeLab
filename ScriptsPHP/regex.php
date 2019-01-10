<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 08/01/2019
 * Time: 10:29
 */

$regex = "/^([0-9]{3})\/([0-9]{4})$/";

$certo = "001/2017";
$errada = "002/2013 Meu nome 002/2013 é Daniel";

echo preg_match($regex, $certo);
echo "<br>";
echo preg_match($regex, $errada);

echo md5('Image248') . '.jpg';