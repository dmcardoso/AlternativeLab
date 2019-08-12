<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 06/02/2019
 * Time: 09:51
 */

$data_search = ['search' => "nome", "limit" => "limite"];
$data_search['modules'] = "modulesss";

//echo "<pre>";
//print_r($data_search);


$array = ['page', 'post', 'vereadores', 'galerias', 'videos', 'concurso_selecao', 'page_vereadores'];

foreach ($array as $i => $v){
    if($v === "concurso_selecao" || $v === 'page_vereadores'){
        $separate = explode('_',$v);
        unset($array[$i]);

        array_push($array, $separate[0]);
        array_push($array, $separate[1]);
    }
}

echo "<pre>";
print_r($array);