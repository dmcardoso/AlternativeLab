<?php
/**
 * Created by PhpStorm.
 * User: João Henrique
 * Date: 08/07/2015
 * Time: 17:15
 */

class BindReplace {

    /**
     * Identificador do colaborador que referencia o usuário do sistema.
     */
    const COLABORADOR_ID = 1000;

    /**
     * Mensagem padrão para abertura de protocolo.
     */
    const MSG_ABERTO = "Protocolo aberto por ";

    /**
     * Mensagem padrão para encerramento de protocolo.
     */
    const MSG_FECHADO = "Protocolo fechado por ";

    /**
     * Mensagem padrão para reabertura de protocolo.
     */
    const MSG_REABERTO = "Protocolo reaberto por ";

    /**
     * Mensagem sistema de abertura de protocolo
     *
     * Ao abrir um protocolo a mensagem é enviada, para notificar por quem e quando o protocolo em questão foi aberto.<br>
     * O padrão de mensagem é defenido pela <b>constante MSG_ABERTO</b> seguido de {<i>id do colaborador atendente</i>}.<br>
     *
     * @param int $atendimento Identificador do atendimento.<br>
     * @param int $colaborador Identificador do colaborador atendente.<br>
     * @return int|string Retorna o id da Mensagem ou <i>string</i> de usuário deslogado.<br>
     * @throws \Exception
     */
    public function abrirProtocolo($atendimento, $colaborador) {
        if (Autenticacao::verificarLogin()) {
            $m = new Mensagem();

            $mensagem = self::MSG_ABERTO . "{" . $colaborador . "}";

            return $m->msgsSistema(["atendimento_id" => $atendimento, "colaborador_id" => self::COLABORADOR_ID, "mensagem" => $mensagem])['id'];
        } else {
            return "useroff";
        }
    }

    /**
     * Mensagem sistema de encerramento de protocolo
     *
     * Ao encerrar um protocolo a mensagem é enviada, para notificar por quem e quando o protocolo em questão foi encerrado.<br>
     * O padrão de mensagem é defenido pela <b>constante MSG_FECHADO</b> seguido de {<i>id do colaborador atendente</i>}.<br>
     *
     * @param array $atendimento Dados do atendimento em questão.<br>
     * $atendimento[<b>colaborador_encerramento</b>] <i>int</i> Identificador do colaborador que encerrou o atendimento.<br>
     * $atendimento[<b>protocolo_id</b>] <i>int</i> Identificador do atendimento encerrado.<br>
     *
     * @return array|string Retorna a mensagem gerada já com o nome do usuário, visto que o padrão da mensagem guarda o id do colaborador <br>
     * ou <i>string</i> de usuário deslogado.
     * @throws \Exception
     */
    public function fecharProtocolo($atendimento) {
        if (Autenticacao::verificarLogin()) {
            $p = new Pessoa();
            $m = new Mensagem();
            $c = new Colaborador();
            $a = new Atendimento();

            $usuario = $atendimento['colaborador_encerramento'];
            $atendimento = $atendimento['protocolo_id'];
            $protocolo = $a->selecionarId($atendimento)['protocolo'];

            //Pega os dados de Colaborador de usuário logado
            $colaborador_nome = $c->selecionarId($usuario)['pessoa_nome'];

            $mensagem = self::MSG_FECHADO . "{" . $usuario . "}";

            $insert = $m->msgsSistema(["atendimento_id" => $atendimento, "colaborador_id" => self::COLABORADOR_ID, "mensagem" => $mensagem]);
            $res['atendente'] = $c->selecionarId(self::COLABORADOR_ID)['pessoa_nome'];
            $res['atendimento_id'] = $atendimento;
            $res['colaborador_id'] = self::COLABORADOR_ID . "";
            $res['id'] = $insert['id'];
            $res['data_db'] = date("Y-m-d H:i:00", strtotime($insert['data']));
            $res['data'] = $this->tratarData($insert['data']);
            $res['mensagem'] = $this->BindReplace.class($insert['mensagem'], $colaborador_nome);
            $res['protocolo'] = $protocolo;
            return $res;
        } else {
            return "useroff";
        }
    }

    /**
     * Mensagem sistema de reabertura de protocolo
     *
     * Ao reabrir um protocolo a mensagem é enviada, para notificar por quem e quando o protocolo em questão foi reaberto.<br>
     * O padrão de mensagem é defenido pela <b>constante MSG_REABERTO</b> seguido de {<i>id do colaborador atendente</i>}.<br>
     *
     * @param array $atendimento Dados do atendimento em questão.<br>
     * $atendimento[<b>colaborador_reabertura</b>] <i>int</i> Identificador do colaborador que reabriu o atendimento.<br>
     * $atendimento[<b>protocolo_id</b>] <i>int</i> Identificador do atendimento reaberto.<br>
     *
     * @return array|string Retorna a mensagem gerada já com o nome do usuário, visto que o padrão da mensagem guarda o id do colaborador <br>
     * ou <i>string</i> de usuário deslogado.
     * @throws \Exception
     */
    public function reabrirProtocolo($atendimento) {
        if (Autenticacao::verificarLogin()) {
            $p = new Pessoa();
            $m = new Mensagem();
            $c = new Colaborador();
            $a = new Atendimento();

            $usuario = $atendimento['colaborador_reabertura'];
            $atendimento = $atendimento['protocolo_id'];
            $protocolo = $a->selecionarId($atendimento)['protocolo'];

            //Pega os dados de Colaborador de usuário logado
            $colaborador_nome = $c->selecionarId($usuario)['pessoa_nome'];

            $mensagem = self::MSG_REABERTO . "{" . $usuario . "}";

            $insert = $m->msgsSistema(["atendimento_id" => $atendimento, "colaborador_id" => self::COLABORADOR_ID, "mensagem" => $mensagem]);
            $res['atendente'] = $c->selecionarId(self::COLABORADOR_ID)['pessoa_nome'];
            $res['atendimento_id'] = $atendimento;
            $res['colaborador_id'] = self::COLABORADOR_ID . "";
            $res['id'] = $insert['id'];
            $res['data_db'] = date("Y-m-d H:i:00", strtotime($insert['data']));
            $res['data'] = $this->tratarData($insert['data']);
            $res['mensagem'] = $this->BindReplace.class($insert['mensagem'], $colaborador_nome);
            $res['protocolo'] = $protocolo;
            return $res;
        } else {
            return "useroff";
        }
    }

    /**
     * Tratar data
     *
     * Converte a data para o formato "00/00/0000 00:00:00". Se a data atual for igual a <b>$data</b> passada, o método subtitui<br>
     * a data pela <i>string</i> "hoje às" seguido da hora no formato normal.
     *
     * @param $data
     * @return false|string
     */
    public function tratarData($data) {
        if (strtotime(date("Y-m-d")) == strtotime(date("Y-m-d", strtotime($data)))) {
            return "Hoje às " . date("H:i:s", strtotime($data));
        } else {
            return date("d/m/Y H:i:s", strtotime($data));
        }
    }

    /**
     * Binds da mensagem do sistema
     *
     * O método em questão recebe a mensagem gerada pelo sistema e analisa na mesma se contém o padrão de identificação,<br>
     * a início apenas de colaborador que realizou alguma ação no protocolo. Por meio de uma expressão regular e usando a <br>
     * função nativa do php <i>preg_match_all</i>, identifica o delimitador e retorna um array de dois índices.<br>
     * O primeiro índice contém a parte retirada da mensagem, o valor original que está contido na mensagem.<br>
     * O segundo índice contém o valor que está entre as chaves, no caso o id do colaborador.<br>
     * Se a mensagem em questão conter apenas um desse valor esperado o retorno será de dois índices [<b>original</b>], <br>
     * representando o que estava na mensagem para posteriormente ser substituído pelo nome do colaborador, e <br>
     * [<b>valor</b>], que seria o valor entre as chaves com a ausência das mesmas.<br>
     * O método também está preparado para receber mais de um valor como esse, caso o ocorra, o retorno será um array de<br>
     * arrays contendo os mesmos índices anteriormente citados, caso a ocorrência do padrão esperado para a mensagem seja<br>
     * apenas um. Caso não encontre nenhum valor esperado pela expressão regular, será retornado null.
     *
     * @param string $mensagem Mensagem do sistema.<br>
     *
     * @return array|null Retorna um array contendo o valor original encontrado na mensagem em questão e o que contém entre <br>
     * os delimitadores da expressão regular ou caso a ocorrência seja superior a 1, retorna um array de arrays com os mesmos índices.<br>
     * ou <i>null</i> caso a ocorrência do padrão esperado seja 0.
     */
    public function pegarBinds($mensagem) {
        $expression = '/\{(.*?)\}/';

        $matches = [];
        $valores = [];
        $final = [];

        $result = preg_match_all($expression, $mensagem, $matches);

        if ($result > 0 && count($matches) == 2) {
            foreach ($matches[0] as $i => $v) {
                $valores[]['original'] = $v;
            }
            foreach ($matches[1] as $i => $v) {
                $valores[$i]['valor'] = $v;
            }

            if (count($valores) == 1) {
                $final['original'] = $valores[0]['original'];
                $final['valor'] = $valores[0]['valor'];
            } else {
                $final = $valores;
            }

            return $final;
        } else {
            return null;
        }
    }

    /**
     * Substituição dos binds na mensagem
     *
     * O método em questão recebe a mensagem gerada pelo sistema e substitui os valores entre chaves pelos parâmetros desejados.<br>
     * Por padrão ele pega o retorno da função de separar os binds e faz a verificação se possui os índices [<b>original</b>] e <br>
     * [<b>valor</b>], neste caso possui apenas uma ocorrência do padrão esperado e então substituir os valores na string. <br>
     * Caso a condição não tenha sido satisfeita, há uma nova verificação se o array de binds é maior que 0 e então substitui<br>
     * respectivamente os valores, cada valor deverá estar na ordem em que dever substituído.<br>
     * Caso nenhuma dessa condições seja satisfeita ele retorna null, já que não foi encontrado nenhum valor a ser substituído.
     * Se <b>$bind</b> for passado como parâmetro, o método não executa a função de separar os binds novamente.
     *
     * @param string $msg A mensagem em que os valores serão substituídos.
     * @param array | string $values Array de índices para serem substituídos na mensagem em questão, caso possua mais de um<br>
     * valor a ser substituído, ou string caso seja apenas uma ocorrência.
     * @param null $bind (<b>Opcional</b>) Esse parâmetro diz respeito aos binds encontrados na mensagem, caso não seja enviado<br>
     * a função que é encarregada de retorná-los é chamada.
     * @return string| null String caso encontre binds a serem substituídos, independente da quantidade. Ou null caso não haja nenhum<br>
     * valor a ser substituído.
     */
    public function BindReplace($msg, $values, $bind = null) {
        $binds = $bind ?? $this->pegarBinds($msg);
        $originais = [];

        if (isset($binds['original']) && isset($binds['valor'])) {
            return str_replace($binds['original'], $values, $msg);
        } else if (count($binds) > 0) {
            foreach ($binds as $i => $v) {
                $originais[] = $v['original'];
            }
            return str_replace($originais, $values, $msg);
        } else
            return null;
    }

}