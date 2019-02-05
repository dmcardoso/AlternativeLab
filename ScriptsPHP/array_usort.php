<?php
function cmp($a, $b) {
    return strcmp($a, $b);
}

$frutas[] = "limoes";
$frutas[] = "abacaxis";
$frutas[] = "goiabas";

usort($frutas, "cmp");

foreach ($frutas as $chave => $valor) {
    echo "{$frutas[$chave]}: " . $valor . "<br>";
}
?>