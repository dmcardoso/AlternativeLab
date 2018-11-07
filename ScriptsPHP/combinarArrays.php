<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 07/11/2018
 * Time: 17:00
 */

$arrayA = ["a", "b", "c"];
$arrayB = ["d", "e", "f"];
$arrayC = array_merge($arrayA, $arrayB);

echo "<pre>";
print_r($arrayA + $arrayB);
echo "<br>";
print_r($arrayC);
echo "<br>";



?>