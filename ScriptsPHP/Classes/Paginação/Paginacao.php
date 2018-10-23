<?php

namespace App\Core;
/**
 * Description of Paginacao
 *
 * @author Daniel Moreira
 */
class Paginacao {

    private $paginaAtual, $quantidadeDePaginas, $inicioPaginacao;
    private $fimPaginacao, $quantidadeASerExibida, $quantidadeRegistrosPorPagina;
    private $quantidadeRegistros, $registroInicial;

    function __construct($quantidadeRegistros, $quantidadePorPagina = 10) {
        $this->quantidadeRegistros = $quantidadeRegistros;
        $this->setPaginaAtual();
        $this->setQuantidadePorPagina($quantidadePorPagina);
        $this->setQuantidadeASerExibida();
        $this->setQuantidadeDePaginas();
        $this->setRegistroInicial();
        $this->renderizaPaginacao();
    }

    //Métodos para setar atributos necessários
    function setQuantidadeExibicao($quantidadeASerExibida) {
        $this->quantidadeASerExibida = $quantidadeASerExibida;
    }

    function setQuantidadeASerExibida() {
        if ($this->quantidadeASerExibida) {
            $this->quantidadeASerExibida = $this->quantidadeASerExibida;
        } else {
            $this->quantidadeASerExibida = 3;
        }
    }

    public function setQuantidadeDePaginas() {
        $this->quantidadeDePaginas = ceil($this->quantidadeRegistros / $this->quantidadeRegistrosPorPagina);
    }

    public function setQuantidadePorPagina($quantidadePorPagina) {
        if ($_GET['qt']) {
            $this->quantidadeRegistrosPorPagina = $_GET['qt'];
        } else {
            $this->quantidadeRegistrosPorPagina = $quantidadePorPagina;
        }
    }

    function setQuantidadeRegistros($quantidadeRegistros) {
        $this->quantidadeRegistros = $quantidadeRegistros;
    }

    public function setPaginaAtual() {
        if ($_GET['pg']) {
            $this->paginaAtual = $_GET['pg'];
        } else {
            $this->paginaAtual = 1;
        }
    }

    //Registro do banco o qual será o inicial
    public function setRegistroInicial() {
        if ($this->paginaAtual == 1) {
            $this->registroInicial = 0;
        } else {
            $this->registroInicial = (($this->paginaAtual * $this->quantidadeRegistrosPorPagina) - ($this->quantidadeRegistrosPorPagina));
        }
    }

    //Se precisar
    public function registroFinal($registroInicial, $quantidadePorPagina, $pagina) {
        if ($pagina == 1) {
            return $quantidadePorPagina - 1;
        } else {
            return $registroInicial + $quantidadePorPagina - 1;
        }
    }


    public function renderizaPaginacao() {
        if ($this->quantidadeDePaginas > $this->quantidadeASerExibida) {
            if ($this->paginaAtual > $this->teto($this->quantidadeASerExibida)) {
                if ($this->paginaAtual > $this->quantidadeDePaginas - $this->teto($this->quantidadeASerExibida)) {
                    $this->inicioPaginacao = $this->quantidadeDePaginas - ($this->quantidadeASerExibida - 1);
                    $this->fimPaginacao = $this->quantidadeDePaginas;
                } else {
                    $this->inicioPaginacao = $this->paginaAtual - ($this->teto($this->quantidadeASerExibida) - 1);
                    $this->fimPaginacao = $this->paginaAtual + $this->chao($this->quantidadeASerExibida);
                }
            } else {
                $this->inicioPaginacao = 1;
                $this->fimPaginacao = $this->quantidadeASerExibida;
            }
        } else {
            $this->inicioPaginacao = 1;
            $this->fimPaginacao = $this->quantidadeDePaginas;
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

    //Se Precisar
    public function configuraLista($lista, $registroInicial, $registroFinal) {
        if ($lista) {
            $novaLista = array();
            for ($i = $lista[$registroInicial]; i <= $lista[$registroFinal]; $i++) {
                array_push($novaLista, $lista[$i]);
            }
            var_dump($novaLista);
            return $novaLista;
        }
    }

    //Métodos para retornar os registros
    function getQuantidadeRegistros() {
        return $this->quantidadeRegistros;
    }

    function getInicioPaginacao() {
        return $this->inicioPaginacao;
    }

    function getFimPaginacao() {
        return $this->fimPaginacao;
    }

    function getRegistroInicial() {
        return $this->registroInicial;
    }

    function getQuantidadeDePaginas() {
        return $this->quantidadeDePaginas;
    }

    function getPaginaAtual() {
        return $this->paginaAtual;
    }

    function getQuantidadeRegistrosPorPagina() {
        return $this->quantidadeRegistrosPorPagina;
    }
}

?>