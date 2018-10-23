<?php

header("Content-Type: text/html; charset=utf-8");
mb_internal_encoding("UTF-8");

$stringCerta = "https://www.youtube.com/watch?v=8_LHVEsYRVE";
$stringErrada = "asdfadfsdfasdf";

if(strstr($stringCerta,"v=") != false){
    echo "Tem v=";
}else{
    echo "Não tem";
}

echo "<br>";
//echo utf8_decode("DOCO-e-Edi%C3%A7ao-semanal-0008-2018-dia-06-de-ABRIL.pdf");
echo mb_convert_encoding("DOCO-e-Edi%C3%A7%C3%A3o-Especial-0001-de-21-de-Setembro-de-2017.pdf", 'UTF-8', 'auto');