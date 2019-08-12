<?php
date_default_timezone_set("America/Sao_Paulo");
$path = "E:xamp/htdocs";
//$diretorio = dir($path);
$dir = scandir($path);
echo "<pre>";
//print_r($dir);
echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
foreach($dir as $i => $file){
    $arquivo = stat($path . '/' . $file);

    $tamanho = $arquivo[7] / 1024;
    echo  strftime('%d-%m-%Y %H:%M:%S', $arquivo['mtime']) . "   Acesso:  ". strftime('%d-%m-%Y %H:%M:%S', $arquivo['atime']) ."  tamanho: {$tamanho}Kb   pasta: {$dir[$i]}   " .  "<br>";
    //print_r($arquivo);

}
?>