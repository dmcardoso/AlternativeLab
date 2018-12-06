<?php

try {
    $data_publicacao = "2018-11-21";
    $data_atual = new DateTime(date('Y-m-d'));
    $data_publicacao = new DateTime($data_publicacao);

    $mes_atual = $data_atual->format('m');
    $mes_ultima_publicacao = $data_atual->format('m');
    $periodo = [];

    switch ($mes_atual) {
        case '01':
        case '02':
            $periodo = ['bimestre' => '1º Bimestre', 'quadrimestre' => '1º Quadrimestre', 'semestre' => '1º Semestre'];
            break;
        case '03':
        case '04':
            $periodo = ['bimestre' => '2º Bimestre', 'quadrimestre' => '1º Quadrimestre', 'semestre' => '1º Semestre'];
            break;
        case '05':
        case '06':
            $periodo = ['bimestre' => '3º Bimestre', 'quadrimestre' => '2º Quadrimestre', 'semestre' => '1º Semestre'];
            break;
        case '07':
        case '08':
            $periodo = ['bimestre' => '4º Bimestre', 'quadrimestre' => '2º Quadrimestre', 'semestre' => '2º Semestre'];
            break;
        case '09':
        case '10':
            $periodo = ['bimestre' => '5º Bimestre', 'quadrimestre' => '3º Quadrimestre', 'semestre' => '2º Semestre'];
            break;
        case '11':
        case '12':
            $periodo = ['bimestre' => '6º Bimestre', 'quadrimestre' => '3º Quadrimestre', 'semestre' => '2º Semestre'];
            break;
    }

    echo "<br><pre>";

    print_r($periodo);

    $mes = '02';      // Mês desejado, pode ser por ser obtido por POST, GET, etc.
    $ano = date("Y"); // Ano atual
    $ultimo_dia = date("t", mktime(0,0,0,$mes,'01','2012')); // Mágica, plim!
    print_r($ultimo_dia);

} catch (Exception $e) {
    echo $e;
}

$now = date('m');

//$format = date_format($now, 'm');
//echo $now;

try {
//    $interval = new DateInterval('PM');


    echo "<br><pre>";
//    print_r($interval->m);
} catch (Exception $e) {
    echo $e;
}


?>