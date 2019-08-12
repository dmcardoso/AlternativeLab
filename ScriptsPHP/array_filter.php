<?php
function impar($var) {
    // retorna se o inteiro informado é impar
    return ($var & 1);
}

function par($var) {
    // retorna se o inteiro informado é par
    return (!($var & 1));
}

$array1 = array("a" => 1, "b" => 2, "c" => 3, "d" => 4, "e" => 5);
$array2 = array(6, 7, 8, 9, 10, 11, 12);

echo "Impares: <br>";
$impares = array_filter($array1, "impar");
echo "<pre>";
print_r($impares);
echo "</pre>";
echo "Pares: <br>";
$pares = array_filter($array2, "par");
echo "<pre>";
print_r($pares);
echo "</pre>";



$array3 = [4,5,6,7,8,9,4,4,5,6,7,8];
echo "Diferentes: <br>";
$diferentes = array_filter($array3, function($array) {
    return $array !== 4;
});
echo "<pre>";
print_r($diferentes);
echo "</pre>";
?>