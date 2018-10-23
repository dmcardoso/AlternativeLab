<?php
//Controla o diretório
chdir("E:\\xamp\\htdocs\\NucleoWeb");
//Executa o comando no diretório da execução atual
$output = shell_exec('git status');
echo "<pre>$output</pre>";
?>