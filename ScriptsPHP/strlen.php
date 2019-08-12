<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 31/10/2018
 * Time: 11:02
 */

$string = "O Objetivo deste trabalho foi agilizar o processo da demanda de lanches (sanduíches) de um estabelecimento de lanches (Pitdog). A problemática se deu da necessidade em diminuir o tempo em que os pedidos eram feitos até o processo de entrega dos mesmos.
Havia problemas na organização desse processo, observando que quando dois ou mais garçons trabalhavam juntos, e o lanche ficava pronto, caso o garçon que fez o pedido de determinada mesa, o mesmo ficava parado em cima de um balcão esperando para ser entregue mais que o necessário, fazendo com que lanche se esfriasse e provocando a insatisfação do mesmo.
Observando esse processo, notamos que um sistema de comandas com senhas e um painel de senha digital eletrônico resolveria tanto o problema citado de não saber de quem era o pedido que estava pronto, quanto no controle do caixa em relaçao ao o que cada mesa consumiu.";

$tamanho = strlen($string);
$palavras = count(explode( " ",$string));

echo "A frase <br>{$string}<br> possui {$tamanho} caraceres e {$palavras} palavras";

?>