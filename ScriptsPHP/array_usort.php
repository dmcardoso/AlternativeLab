<?php
function cmp($a, $b) {
    echo $a;
    return strcmp($a, $b);
}

$frutas['arroz'] = "limoes";
$frutas['aluguel'] = "abacaxis";
$frutas['banana'] = "goiabas";

usort($frutas, "cmp");

echo "<pre>";
print_r($frutas);
?>