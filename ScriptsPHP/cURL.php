<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 07/11/2018
 * Time: 11:13
 */

/*Requisições externas*/
/*Requisições posts*/

function sendPost($url){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 1);


}

sendPost("https://alunos.b7web.com.br/api/ping");



?>