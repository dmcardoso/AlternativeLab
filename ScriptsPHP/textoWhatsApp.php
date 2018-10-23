<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 27/08/2018
 * Time: 13:12
 */

$textoLiteral = "[11:15, 27/8/2018] Netinho Salva: Oi bom dia
[11:15, 27/8/2018] Suporte Núcleo: quem é do TI ?
[11:16, 27/8/2018] Suporte Núcleo: ae da prefeitura ?
[11:16, 27/8/2018] Netinho Salva: Técnico da informação?
[11:16, 27/8/2018] Suporte Núcleo: isso
[11:17, 27/8/2018] Netinho Salva: O Delcimar é formado nessa área
[11:17, 27/8/2018] Suporte Núcleo: quem tem acesso ao servidor ae ?
[11:17, 27/8/2018] Suporte Núcleo: é ele?";

$textoNoBanco = "[11:15, 27/8/2018] Netinho Salva: Oi bo:m dia
<br />[11:15, 27/8/2018] Suporte Núcleo: quem é do TI ?
<br />[11:16, 27/8/2018] Suporte Núcleo: ae da prefeitura ?
<br />[11:16, 27/8/2018] Netinho Salva: Técnico da informação?
<br />[11:16, 27/8/2018] Suporte Núcleo: isso
<br />[11:17, 27/8/2018] Netinho Salva: O Delcimar é formado nessa área
<br />[11:17, 27/8/2018] Suporte Núcleo: quem tem acesso ao servidor ae ?
<br />[11:17, 27/8/2018] Suporte Núcleo: é ele?";

$textoComEspaco = "[13:21, 27/8/2018] Suporte Núcleo: oi
<br />Boa tarde!
<br />tudo bem?
<br />[13:22, 27/8/2018] Suporte Núcleo: aqui é da empresa núcleo";

$dataHora = "[13:21, 27/8/2018] essa é a mensagem";
//
//echo $textoLiteral . '<br>=============================<br>';
//echo $textoNoBanco;

$quebradata = explode(" ", $dataHora, 3);

$hora = substr($quebradata[0], 1, -1);
$data = substr($quebradata[1], 0, -1);
$data = explode("/", $data)[2] . '-' . ((strlen(explode("/", $data)[1]) == 1) ? "0" . explode("/", $data)[1] : explode("/", $data)[1]) . '-' . explode("/", $data)[0];

$dataDate = date("Y-m-d H:i:s", strtotime($data . " " . $hora));


//echo "<pre>";
//var_dump($quebraMensagem);
//echo "<br> ==================================================== <br>";

$quebraMensagem = explode("<br />", $textoNoBanco);



$quebradata = explode(" ", $textoNoBanco, 3);

if (isset($quebradata[0]) && isset($quebradata[1])) {
    $hora = substr($quebradata[0], 1, -1);
    $data = substr($quebradata[1], 0, -1);
    if (count(explode("/", $data)) >= 3 && strtotime($hora)) {
        echo "whats app";
    }else{
        echo "normal";
    }
}

$mensagem = [];

$anterior = 1;
foreach ($quebraMensagem as $i => $m) {

    $quebradata = explode(" ", $m, 3);

    if (isset($quebradata[0]) && isset($quebradata[1])) {
        $hora = substr($quebradata[0], 1, -1);
        $data = substr($quebradata[1], 0, -1);
        if (count(explode("/", $data)) >= 3 && strtotime($hora)) {
            $data = explode("/", $data)[2] . '-' . ((strlen(explode("/", $data)[1]) == 1) ? "0" . explode("/", $data)[1] : explode("/", $data)[1]) . '-' . explode("/", $data)[0];
            $dataDate = date("Y-m-d H:i:s", strtotime($data . " " . $hora));
        }
    }

    if (isset($dataDate) && strtotime($dataDate)) {
        $autorMensagem = explode(":", $quebradata[2], 2);
        $autor = $autorMensagem[0];

        if ($autor == "Suporte Núcleo") {
            $autor = "atendente";
        } else {
            $autor = "cliente";
        }

        $msg = $autorMensagem[1];
        $mensagem[] = trim($msg);
        $anterior = 1;
    } else {
        $mensagem[($i - $anterior)] .= "<br />" . $m;
        $anterior++;
    }
}

//echo "<pre>";
//var_dump($mensagem);


?>