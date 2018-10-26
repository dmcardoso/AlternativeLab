<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 12/09/2018
 * Time: 15:02
 */

$string = "Protocolo aberto por qualquer um";

$string = explode(" ", $string, 3);

print_r($string);


echo "<pre>";
$string_ = "192_capa_";
print_r(explode("_",$string_));

?>