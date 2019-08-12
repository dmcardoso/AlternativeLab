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

//    print_r($periodo);

    $mes = '02';      // Mês desejado, pode ser por ser obtido por POST, GET, etc.
    $ano = date("Y"); // Ano atual
    $ultimo_dia = date("t", mktime(0, 0, 0, $mes, "01", '2013')); // Mágica, plim!
    print_r($ultimo_dia);

    // Mais 30 dias
    $time = (30 * 24 * 60 * 60) + strtotime(date("Y-m-d"));
    echo "<br>" . $time . "<br>";
    echo date("Y-m-d", $time) . "<br>";

    $mes_1 = "01";
    $mes_2 = "02";
    $mes_3 = "03";
    $mes_4 = "04";
    $mes_5 = "05";
    $mes_6 = "06";
    $mes_7 = "07";
    $mes_8 = "08";
    $mes_9 = "09";
    $mes_10 = "11";
    $mes_11 = "11";
    $mes_12 = "12";

    $bimestre = ceil((int)$mes_5 / 2);
//    echo "<br>" . $bimestre . "<br><br>";

//    echo(date("Y-m-d"));
    echo "<br> >>>";
    echo date("Y-m-d H:i:s", '1543543200');
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