<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 07/02/2019
 * Time: 10:08
 */

$busca = "Aenean";
$string = " Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed libero nibh. Curabitur malesuada aliquet risus, ac commodo mauris rutrum porta. Cras ut condimentum est, vitae ornare urna. Nulla iaculis elementum vehicula. Fusce mi nunc, sodales sit amet faucibus ut, commodo nec dolor. Maecenas non libero tincidunt, imperdiet enim congue, dictum turpis. Nam scelerisque lorem ut tortor lacinia, in placerat velit egestas. Vestibulum quis pretium tellus, vitae faucibus sapien. Quisque id tempus felis.

Aliquam a est pharetra, mollis justo at, porttitor urna. Phasellus pretium ligula nec eros porttitor dapibus. Quisque efficitur ornare dui a consectetur. Ut pretium ultrices iaculis. In porttitor elit nec gravida bibendum. Ut varius ornare lectus, quis iaculis quam varius eget. Donec hendrerit diam sed elementum tincidunt.

Nulla posuere vulputate turpis, eget dapibus tortor pharetra eget. Nulla a lacus quis libero pretium consequat. Sed varius turpis non orci rutrum placerat. Fusce dui leo, accumsan at tempor sit amet, dapibus a libero. Nullam eu iaculis dui. Mauris eget commodo sem, sed imperdiet libero. Donec sed faucibus lectus. Suspendisse non euismod justo. Quisque risus nisi, rutrum vitae nunc non, ultricies faucibus libero. Donec luctus ligula ut elit convallis, eu dapibus elit sagittis. Nunc pretium commodo orci a feugiat.

Sed dignissim hendrerit diam, quis volutpat risus blandit id. Nullam mi lacus, laoreet congue ullamcorper id, placerat at mi. Aenean vel sodales felis. Ut porttitor mollis faucibus. Nulla rhoncus, orci ac placerat auctor, elit erat vehicula felis, at blandit augue lectus nec mauris. Suspendisse pellentesque auctor pharetra. Sed ac lectus est. Ut at facilisis sapien. Phasellus condimentum risus vel eros auctor, quis imperdiet risus porttitor. Curabitur luctus non nisl nec condimentum. Donec massa odio, tempor id suscipit vel, vehicula et elit. Proin a nibh elementum neque rutrum lacinia. Duis sollicitudin dapibus sem id consectetur. Morbi augue purus, ultrices non fringilla et, bibendum ac sapien. Morbi sagittis tincidunt nibh at consequat.";

$stringTemporaria = mb_strtolower($string);
$buscaTemporaria  = mb_strtolower($busca);

//$string_limit = "";
//if(mb_strpos($stringTemporaria, $buscaTemporaria) <= 150){
//    echo "menor";
//    echo mb_strpos($stringTemporaria, $buscaTemporaria);
//}else{
//    echo "maior";
//}
$original = strlen($string);
$limitada_na_ocorrencia = strlen(strstr($stringTemporaria, $buscaTemporaria));
$tamaho_limitado = strlen(substr(strstr($stringTemporaria, $buscaTemporaria), 0, 200));
//echo $original . "<br>";
//echo $limitada_na_ocorrencia . "<br>";
//echo $tamaho_limitado . "<br>";
//echo $original - $limitada_na_ocorrencia;
//$nao_sei = strstr($stringTemporaria, $buscaTemporaria);
//echo $nao_sei
$position = mb_strpos($stringTemporaria, $buscaTemporaria);

//echo substr($string, $position, 200);

//echo $position;
$string_limit = "";

if($position <= 90){
    $string_limit = substr($string, 0, ($position + 400));
    $string_limit .= (strlen($string) > ($position + 400)) ? " ..." : "";
}else{
    $string_limit = "... " . substr($string, ($position - 90), ($position + 310));
    $string_limit .= (strlen($string) > ($position + 310)) ? " ..." : "";
}
echo $string_limit;
?>