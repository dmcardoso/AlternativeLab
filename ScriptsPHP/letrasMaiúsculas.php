<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 22/08/2018
 * Time: 16:03
 */

echo "<pre>";

$frase = "essa é e uma frase de teste";
$dayane = "dayane dos santos";
$pedro = "pedro de jesus";
$augusto = "augusto das oliveiras";

$letras = "de";

//echo strlen($letras);


function mudaNome($nome) {
    $preposicoes = ["das", "dos", "des", "dus"];
    $quebrado = explode(" ", $nome);

    foreach ($quebrado as $i => $v) {
        if (strlen($v) == 2 || in_array(strtolower($v), $preposicoes)) {
            $quebrado[$i] = strtolower($v);
        }else{
            $quebrado[$i] = ucwords(strtolower($v));
        }
    }

    echo implode(" ", $quebrado) . "<br><br>";
}

echo $frase . "<br>";
mudaNome($frase);
echo $dayane . "<br>";
mudaNome($dayane);
echo $pedro . "<br>";
mudaNome($pedro);
echo $augusto . "<br>";
mudaNome($augusto);

//echo ucwords($frase);

?>