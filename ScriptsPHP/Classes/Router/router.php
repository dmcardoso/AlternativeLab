<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 05/11/2018
 * Time: 10:35
 */

require "Router.class.php";

$r = new Router(['namespace' => 'App/Controllers', 'file' => "UsuArio", "method" => "Clonar_USSA"]);

$rota = $r->getPathClass();
$metodo = $r->getMethod();
echo $rota . "    " . $metodo;