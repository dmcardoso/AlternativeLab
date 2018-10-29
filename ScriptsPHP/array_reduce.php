<?php
$array3 = [4, 5, 6, 7, 8, 9, 4, 4, 5, 6, 7, 8];
echo "Diferentes: <br>";
$diferentes = array_reduce($array3, function ($array, $nome) {
    $array += $nome;
    return $array;
});
echo "<pre>";
print_r($diferentes);
echo "</pre>";
?>