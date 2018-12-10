<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/12/2018
 * Time: 10:01
 */

class Time {

    /**
     * @return array
     * @throws \Exception
     */
    public function periodoAtual() {
        $data_atual = new DateTime(date('Y-m-d'));

        $mes_atual = $data_atual->format('m');

        $periodo = [];
        $periodo['ano'] = $data_atual->format('Y');
        $periodo['mes'] = $data_atual->format('m');
        $periodo['dia'] = $data_atual->format('d');
        $periodo['data'] = $data_atual->format('Y-m-d');
        $periodo['bimestres'] = ['1º Bimestre', '2º Bimestre', '3º Bimestre', '4º Bimestre', '5º Bimestre', '6º Bimestre'];
        $periodo['quadrimestres'] = ['1º Quadrimestre', '2º Quadrimestre', '3º Quadrimestre'];
        $periodo['semestres'] = ['1º Semestre', '2º Semestre'];
        $periodo['qtde_bimestres'] = ceil((int)$periodo['mes'] / 2);
        $periodo['qtde_quadrimestres'] = ceil((int)$periodo['mes'] / 4);
        $periodo['qtde_semestres'] = ceil((int)$periodo['mes'] / 6);

        switch ($mes_atual) {
            case '01':
            case '02':
                $periodo = array_merge($periodo, [
                    'bimestre' => $periodo['bimestres'][0],
                    'quadrimestre' => $periodo['quadrimestres'][0],
                    'semestre' => $periodo['semestres'][0],
                    'final_bimestre' => date("Y-m-t", mktime(0, 0, 0, "02", "01", $periodo['ano'])),
                    'final_quadrimestre' => date("Y-m-t", mktime(0, 0, 0, "04", "01", $periodo['ano'])),
                    'final_semestre' => date("Y-m-t", mktime(0, 0, 0, "06", "01", $periodo['ano'])),
                ]);
                break;
            case '03':
            case '04':
                $periodo = array_merge($periodo, [
                    'bimestre' => $periodo['bimestres'][1],
                    'quadrimestre' => $periodo['quadrimestres'][0],
                    'semestre' => $periodo['semestres'][0],
                    'final_bimestre' => date("Y-m-t", mktime(0, 0, 0, "04", "01", $periodo['ano'])),
                    'final_quadrimestre' => date("Y-m-t", mktime(0, 0, 0, "04", "01", $periodo['ano'])),
                    'final_semestre' => date("Y-m-t", mktime(0, 0, 0, "06", "01", $periodo['ano']))
                ]);
                break;
            case '05':
            case '06':
                $periodo = array_merge($periodo, [
                    'bimestre' => $periodo['bimestres'][2],
                    'quadrimestre' => $periodo['quadrimestres'][1],
                    'semestre' => $periodo['semestres'][0],
                    'final_bimestre' => date("Y-m-t", mktime(0, 0, 0, "06", "01", $periodo['ano'])),
                    'final_quadrimestre' => date("Y-m-t", mktime(0, 0, 0, "08", "01", $periodo['ano'])),
                    'final_semestre' => date("Y-m-t", mktime(0, 0, 0, "06", "01", $periodo['ano']))
                ]);
                break;
            case '07':
            case '08':
                $periodo = array_merge($periodo, [
                    'bimestre' => $periodo['bimestres'][3],
                    'quadrimestre' => $periodo['quadrimestres'][1],
                    'semestre' => $periodo['semestres'][1],
                    'final_bimestre' => date("Y-m-t", mktime(0, 0, 0, "08", "01", $periodo['ano'])),
                    'final_quadrimestre' => date("Y-m-t", mktime(0, 0, 0, "08", "01", $periodo['ano'])),
                    'final_semestre' => date("Y-m-t", mktime(0, 0, 0, "12", "01", $periodo['ano']))
                ]);
                break;
            case '09':
            case '10':
                $periodo = array_merge($periodo, [
                    'bimestre' => $periodo['bimestres'][4],
                    'quadrimestre' => $periodo['quadrimestres'][2],
                    'semestre' => $periodo['semestres'][1],
                    'final_bimestre' => date("Y-m-t", mktime(0, 0, 0, "10", "01", $periodo['ano'])),
                    'final_quadrimestre' => date("Y-m-t", mktime(0, 0, 0, "12", "01", $periodo['ano'])),
                    'final_semestre' => date("Y-m-t", mktime(0, 0, 0, "12", "01", $periodo['ano']))
                ]);
                break;
            case '11':
            case '12':
                $periodo = array_merge($periodo, [
                    'bimestre' => $periodo['bimestres'][5],
                    'quadrimestre' => $periodo['quadrimestres'][2],
                    'semestre' => $periodo['semestres'][1],
                    'final_bimestre' => date("Y-m-t", mktime(0, 0, 0, "12", "01", $periodo['ano'])),
                    'final_quadrimestre' => date("Y-m-t", mktime(0, 0, 0, "12", "01", $periodo['ano'])),
                    'final_semestre' => date("Y-m-t", mktime(0, 0, 0, "12", "01", $periodo['ano']))
                ]);
                break;
        }

        // Mais 30 dias
//        $time_stamp = (30 * 24 * 60 * 60) + strtotime($ultimo_dia_mes_full);
//        return date("Y-m-d", $time_stamp);

        return $periodo;
    }

}