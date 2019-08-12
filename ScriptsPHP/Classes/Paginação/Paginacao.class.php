<?php

namespace App\Core;

use Exception;

/**
 * Description of Paginacao
 *
 * @author Daniel Moreira
 */
class Paginacao {

    private $atributes = [];

    function __construct($atributes = []) {
        if (is_array($atributes)) {
            $this->atributes['qtd_registros'] = $atributes['qtd_registros'] ?? null;
            $this->atributes['pag_atual'] = $atributes['pag_atual'] ?? 1;
            $this->atributes['qtd_por_pagina'] = $atributes['qtd_por_pagina'] ?? 10;
            $this->atributes['qtd_exibicao'] = $atributes['qtd_exibicao'] ?? 3;
            $this->atributes['total_paginas'] = $this->getTotalPaginas($atributes['qtd_registros'], $atributes['qtd_por_pagina']);
            $this->atributes['registro_inicial'] = $this->getBegin($atributes['pag_atual'], $atributes['qtd_por_pagina']);
            $this->render();
        } else {
            throw new Exception("Atributos para a classe de paginação devem ser um array");
        }
    }

    public function getTotalPaginas($registros, $qtd_por_pagina) {
        return ceil($registros / $qtd_por_pagina);
    }

    //Registro do banco o qual será o inicial
    public function getBegin($pag_atual, $qtd_por_pagina) {
        if ($pag_atual == 1) {
            return 0;
        } else {
            return (($pag_atual * $qtd_por_pagina) - ($qtd_por_pagina));
        }
    }

    public function render() {
        if ($this->atributes['total_paginas'] > $this->atributes['qtd_exibicao']) {
            if ($this->atributes['pag_atual'] > $this->teto($this->atributes['qtd_exibicao'])) {
                if ($this->atributes['pag_atual'] > $this->atributes['total_paginas'] - $this->teto($this->atributes['qtd_exibicao'])) {
                    $this->atributes['inicio_paginacao'] = $this->atributes['total_paginas'] - ($this->atributes['qtd_exibicao'] - 1);
                    $this->atributes['fim_paginacao'] = $this->atributes['total_paginas'];
                } else {
                    $this->atributes['inicio_paginacao'] = $this->atributes['pag_atual'] - ($this->teto($this->atributes['qtd_exibicao']) - 1);
                    $this->atributes['fim_paginacao'] = $this->atributes['pag_atual'] + $this->chao($this->atributes['qtd_exibicao']);
                }
            } else {
                $this->atributes['inicio_paginacao'] = 1;
                $this->atributes['fim_paginacao'] = $this->atributes['qtd_exibicao'];
            }
        } else {
            $this->atributes['inicio_paginacao'] = 1;
            $this->atributes['fim_paginacao'] = $this->atributes['total_paginas'];
        }
    }

    //ceil
    public function teto($quantidade) {
        return ceil($quantidade / 2);
    }

    //floor
    public function chao($quantidade) {
        return floor($quantidade / 2);
    }

    public function getProperties() {
        return $this->atributes;
    }

    public function getProperty($property) {
        if (in_array($property, array_keys($this->atributes))) {
            return $this->atributes[$property];
        }else{
            throw new Exception("Atributo {$property} não existe na classe");
        }
    }
}

?>