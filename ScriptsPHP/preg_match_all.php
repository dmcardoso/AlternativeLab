<?php

$mensagem = "Protocolo aberto por {45} {64}";
$nomes = ["Daniel Moreira", "Leo Leles"];
$expression = '/\{(.*?)\}/';

$matches = [];
$valores = [];

$result = preg_match_all($expression, $mensagem, $matches);

echo "<pre>";

$expression = '/\{(.*?)\}/';

$matches = [];
$valores = [];
$final = [];

$result = preg_match_all($expression, $mensagem, $matches);

if ($result > 0 && count($matches) == 2) {
    foreach ($matches[0] as $i => $v) {
        $valores[]['original'] = $v;
    }
    foreach ($matches[1] as $i => $v) {
        $valores[$i]['valor'] = $v;
    }

    if (count($valores) == 1) {
        $final['original'] = $valores[0]['original'];
        $final['valor'] = $valores[0]['valor'];
    } else {
        $final = $valores;
    }
}

$originais = [];

if (isset($final['original']) && isset($final['valor'])) {
    $mensagem = str_replace($final['original'], "Daniel", $mensagem);
} else if (count($final) > 0) {
    foreach ($final as $i => $v) {
        $originais[] = $v['original'];
    }

    $mensagem = str_replace($originais, $nomes, $mensagem);

}

print_r($mensagem);

?>