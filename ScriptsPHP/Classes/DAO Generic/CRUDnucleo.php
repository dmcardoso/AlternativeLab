<?php

namespace Nucleo\Core\Dao\Driver\Mysql;

use Nucleo\Core\Dao\Dao;
use Nucleo\Core\Dao\DaoException;
use Nucleo\Helpers\StrRes;
use PDO;

/**
 * Class Driver
 *
 * Responsavel pelas operações de Driver
 *
 * @package Nucleo\Core\DaoMysql
 */
abstract class CRUD extends Dao {
    /**
     * Ultimo sql gerado
     *
     * @var string
     */
    private $last_sql = "";

    /**
     * Retorna o ultimo sql gerado
     *
     * @return string
     */
    protected function getLastSql() {
        return $this->last_sql;
    }

    /**
     * Tipo de insert normal
     */
    const TP_INSERT_NORMAL = 1;
    /**
     * Tipo de insert aplicando um replace
     */
    const TP_INSERT_REPLACE = 2;
    /**
     * Tipo de insert aplicando um on duplicate key
     */
    const TP_INSERT_OR_UPDATE = 3;
    /**
     * Tipo de insert aplicando um ignore
     */
    const TP_INSERT_IGNORE = 4;

    /**
     * Valor a ser inserido
     * É obrigatorio caso o valor do dados seja passado em um array
     */
    const FIELD_VALUE = "value";
    /**
     * Se deve adicionar o campo com "?"
     */
    const FIELD_AUTO_MARK = "auto_mark";
    /**
     * Se o campo deve ser inserido no update quando ocorrer um "ON DUPLICATE KEY"
     */
    const FIELD_UPDATE = "update";

    /**
     * Insert
     *
     * @param string $tabela Nome da tabela para a inserção
     * @param array $data <p>Lista de dados para inserir<br><br>
     * Inserção simples:<br>
     * Ex:
     * <code>
     * [campo1=>valor, campo2=>valor, ...]
     * </code>
     * <br><br>
     * Mudar comportamento da inserção:<br>
     * <b>Os indices estão disponiveis nas constantes iniciadas com "FIELD_...".</b><br>
     * <b>value</b> mixed - (<i>Obrigatorio</i>): O valor que será inserido.<br>
     * <b>auto_mark</b> bool - (<i>Opcional</i>): Se deve aplicar a marcação "?". O padrão é true.<br>
     * <b>update</b> bool - (<i>Opcional</i>): Se o tipo da inserção for "OR_UPDATE", informa se deve
     * atualizar esse campo. O padrão é true.<br>
     * Ex:
     * <code>
     * [campo1=>[value=>valor, auto_mark=>false, ...], campo2=>[value=>valor, ...], ...]
     * </code>
     * <br><br>
     * Para adicionar multiplas linhas basta enviar um array de dados seguindo um dos padrões acima.<br>
     * A ordem das colunas devem ser as mesmas em todas as linhas.<br>
     * Ex:
     * <code>
     * [[id => 1, nome => "exemplo", ...], [id => 2, nome => "exemplo 2", ...], ...]
     * </code>
     * <br><br>
     * Outra possibilidade é passar o nome das colunas no atributo em "fields" e os valores em "values"<br>
     * Ex: <code>[fields => ["id", "nome", ...], values => [1, "exemplo", ...]]</code><br>
     * <br>
     * Ao utilizar uma inserção com multiplas linhas, o indice de cada campo deve ser passado mesmo se<br>
     * o campo "fields" for informado. Nesse caso, informar o "fields" serve apenas para diminuir as chances dos indices<br>
     * entrarem em posições erradas.<br>
     * Ex: <code>[fields => ["id", "nome", ...], values => [id => [1, "exemplo"...], nome => [2, "exemplo 2"...], ...]]</code>
     * </p>
     * @param int $tipo_insert <p>
     * Qual sera o tipo do insert. Os tipos possíveis estão nas constantes iniciadas com "<b>TP_INSERT_...</b>".
     * </p>
     * @return bool|int <p>
     * Retorna um inteiro se um ID auto incremente for gerado.<br>
     * Se for um insert multi linha, o ID retornado será o da primeira linha adicionada.<br>
     * Se nenhum ID for gerado, o metodo retorna true para sucesso e false para falha.
     * </p>
     * @throws DaoException
     */
    protected function create(string $tabela, array $data, $tipo_insert = self::TP_INSERT_NORMAL) {
        // TODO Re-escreve antigo sistema de aplicar o replace. Remover futuramente.
        if ($tipo_insert === false)
            $tipo_insert = self::TP_INSERT_NORMAL; else if ($tipo_insert === true)
            $tipo_insert = self::TP_INSERT_REPLACE;

        if (count($data) == 0) {
            throw new DaoException("Nenhum valor para inserir.");
        }

        $this->autoOpenDB();

        // Campos que receberão os valores
        $campos = [];
        // Os valores que serão adicionados ou o mark("?")
        $params = [];
        // Valores que serão aplicados nos marks("?")
        $valores = [];

        // Campos que não irão entrar nos insertes com ON DUPLICATE KEY
        $no_update = [];

        // Verifica se os campos e os valores foram passados separados
        if (isset($data['fields']) && isset($data['values'])) {
            if (!is_array($data['fields'])) {
                throw new DaoException("Parametro fields deve ser um array.");
            }

            $campos = $data['fields'];
            $list = $data['values'];
        } else {
            $list = $data;
        }

        // Monta os dados para ser inserido no sql
        foreach ($list as $key => $value) {
            if (is_array($value) && isset($value[self::FIELD_VALUE])) {
                $campos[] = $key;

                // Aplica na lista dos que não irão receber o UPDATE
                if (isset($value[self::FIELD_UPDATE]) && $value[self::FIELD_UPDATE] === false && !in_array($key, $no_update))
                    $no_update[] = $key;

                // Não adiciona na lista de entradas marcadas "?"
                if (isset($value[self::FIELD_AUTO_MARK]) && $value[self::FIELD_AUTO_MARK] === false) {
                    $params[] = $value[self::FIELD_VALUE];
                } else {
                    $params[] = "?";
                    $valores[] = $value[self::FIELD_VALUE];
                }
            } else if (gettype($value) == "array") {
                $temp_params = [];
                $temp_campos = [];

                // Se os campos forem informados em "fields", então tenta organizar os valores na ordem deles
                if (isset($data['fields'])) {
                    $aux = [];
                    foreach ($data['fields'] as $i => $v) {
                        $aux[$v] = isset($value[$v]) ? $value[$v] : null;
                    }

                    $value = $aux;
                }

                // Percorre a linha para inserir os valores na query
                foreach ($value as $key2 => $value2) {
                    // Armazena as chaves para fazem uma verificação de posição e quantidade de campos
                    $temp_campos[] = $key2;

                    // Verifica se o tipo de campo foi definido manualmente
                    if (is_array($value2) && isset($value2[self::FIELD_VALUE])) {
                        // Aplica na lista dos que não irão receber o UPDATE
                        if (isset($value2[self::FIELD_UPDATE]) && $value2[self::FIELD_UPDATE] === false && !in_array($key2, $no_update))
                            $no_update[] = $key2;

                        // Não adiciona na lista de entradas marcadas "?"
                        if (isset($value2[self::FIELD_AUTO_MARK]) && $value2[self::FIELD_AUTO_MARK] === false) {
                            $temp_params[] = $value2[self::FIELD_VALUE];
                        } else {
                            $temp_params[] = "?";
                            $valores[] = $value2[self::FIELD_VALUE];
                        }
                    } else {
                        $temp_params[] = "?";
                        $valores[] = $value2;
                    }
                }

                // Faz uma validação para checar se os dados estão certos para inserir
                if (count($campos) == 0) {
                    $campos = $temp_campos;
                } else if (implode(", ", $temp_campos) != implode(", ", $campos)) {
                    throw new DaoException("A posição dos indexes na lista de inserção não esta seguindo a mesma ordem.\n\n" . implode(", ", $campos) . "\n" . implode(", ", $temp_campos) . "\n\n" . "Ex: [[\"id\" => 1, \"nome\" => \"Exemplo 1\"], [\"nome\" => \"Exemplo 2\", \"id\" => 2]...]\n" . "Forma Correta: [[\"id\" => 1, \"nome\" => \"Exemplo 1\"], [\"id\" => 2, \"nome\" => \"Exemplo 2\"]...]");
                }

                $params[] = "(" . implode(", ", $temp_params) . ")";
            } else {
                if (!isset($data['fields']))
                    $campos[] = $key;
                $params[] = "?";
                $valores[] = $value;
            }
        }

        // Junta todos os parametros em um array
        $params = implode(", ", $params);
        // Verifica se ja existe os parenteses no caso dos de multiplas linhas
        $params = StrRes::startsWith($params, "(") ? $params : "(" . $params . ")";

        // Tipo de ação do INSERT
        switch ($tipo_insert) {
            case self::TP_INSERT_REPLACE:
                $acao_insert = "REPLACE";
                break;

            case self::TP_INSERT_IGNORE:
                $acao_insert = "INSERT IGNORE";
                break;

            default:
                $acao_insert = "INSERT";
        }

        $sql = $acao_insert . " INTO " . $tabela . " (" . implode(", ", $campos) . ") VALUES " . $params;

        // Aplica o "ON DUPLICATE KEY" na query
        if ($tipo_insert === self::TP_INSERT_OR_UPDATE) {
            $dados_update = [];
            foreach ($campos as $i => $v) {
                // Verifica se ele não esta na lista dos que não receberão update
                if (!in_array($v, $no_update)) {
                    $dados_update[] = "$v = VALUES($v)";
                }
            }

            if (count($dados_update) > 0) {
                $sql .= " ON DUPLICATE KEY UPDATE " . implode(", ", $dados_update);
            }
        }

        // Guarda sql para depuração
        $this->last_sql = $sql;

        // Executa a query
        if ($this->stmt = $this->con->prepare($sql)) {
            $i = 1;
            while ($i <= count($valores)) {
                $this->stmt->bindValue($i, $valores[$i - 1]);
                $i++;
            }

            $result = $this->stmt->execute();
        } else {
            throw new DaoException("Erro de conexão " . $this->con->errorInfo()[2]);
        }

        // Verifica se a query teve sucesso
        if ($this->stmt->rowCount() > 0) {
            $id = $this->con->lastInsertId();

            $this->autoCloseDB();

            // Verifica se gerou um id auto increment.
            // Se tiver auto increment retorna o inteiro, se não, retorna true para indicar sucesso
            if ($id > 0) {
                return $id;
            } else {
                return true;
            }
        } else {
            $this->autoCloseDB();

            // Retorna true para sucesso ou false para falha
            return $result;
        }
    }

    /**
     * Read
     *
     * Isto é apenas uma consulta generica, caso seja necessario algo mais complexo utilize o metodo
     * prepare ou faça uma conexão direta atraves da instancia do PDO
     *
     * @param string $locais Tabela e JOINs
     * @param string $campos Campos e SUB-QUERYs
     * @param string $where_con As condições para seleção
     * @param array $where_val Os valores para substituir os "?" da condição
     * @param string $group_by Agrupar
     * @param string $having Clausula Having
     * @param string|array $order <p>Ordem da busca<br><br>
     * string "<i>column1 ASC, column2 DESC</i>" sera adicionado diretamente sem validar.<br>
     * array <i>[column1, column2 => DESC, ...]</i> será validado se o campo existe e se é ASC ou DESC
     * </p>
     * @param string|int $limit Limite da leitura
     *
     * @return array
     * @throws DaoException
     */
    protected function read(string $locais, string $campos = "*", string $where_con = null, array $where_val = [], string $group_by = null, string $having = null, $order = null, $limit = null) {
        $campos = ($campos == null) ? "*" : $campos;

        // Valida para evitar problemas com sql injection
        if (!$this->checkLimit($limit)) {
            throw new DaoException("Parâmetro limit inválido.");
        }

        $this->autoOpenDB();

        // Adiciona condição
        $str_params = ($where_con != null) ? "WHERE " . $where_con . " " : "";

        if (is_array($order))
            $order = $this->stringOrderBy($order);

        // Gera sql
        $sql = "SELECT " . $campos . " FROM " . $locais . " " . $str_params;
        $sql .= ($group_by != null) ? "GROUP BY " . $group_by . " " : "";
        $sql .= ($having != null) ? "HAVING " . $having . " " : "";
        $sql .= ($order != null) ? "ORDER BY " . $order . " " : "";
        $sql .= ($limit != null) ? "LIMIT " . $limit : "";

        // Guarda sql para depuração
        $this->last_sql = $sql;

        // Prepara a consulta
        if ($this->stmt = $this->con->prepare($sql)) {

            $i = 1;
            while ($i <= count($where_val)) {
                $this->stmt->bindValue($i, $where_val[$i - 1]);
                $i++;
            }

            // Executa query
            $this->stmt->execute();
        } else {
            throw new DaoException("Erro de conexão " . $this->con->errorInfo()[2]);
        }

        $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);

        $lista = [];

        if (count($result) > 0) {
            if (isset($result[0])) {
                $lista = $result;
            } else {
                $lista = [$result];
            }
        }

        $this->autoCloseDB();

        return $lista;
    }

    /**
     * Update
     *
     * @param string $tabela Nome da tabela para a atualizar
     * @param array $data <p>
     * Lista de campos que serão atualizados<br>
     * Ex: <code>[campo=>valor, campo=>valor...]</code>
     * </p>
     * @param string $where_con As condições para seleção
     * @param array $where_val Os valores para substituir os "?" da condição
     *
     * @return bool
     * @throws DaoException
     */
    protected function update(string $tabela, array $data, string $where_con = "", array $where_val = []) {
        if (count($data) == 0) {
            throw new DaoException("Nenhum valor para atualizar.");
        }

        $this->autoOpenDB();

        $campos = "";

        foreach ($data as $indice => $value) {
            $campos .= ($campos == "") ? $indice . " = ?" : ", " . $indice . " = ?";
        }

        if ($where_con != "") {
            $where_con = "WHERE " . $where_con;
        }

        // Prepara query
        $sql = "UPDATE " . $tabela . " SET " . $campos . " " . $where_con;

        // Guarda sql para depuração
        $this->last_sql = $sql;

        // Executa a query
        if ($this->stmt = $this->con->prepare($sql)) {
            $i = 1;

            // Adiciona os valores que serão atualizados no bind value
            foreach ($data as $indice => $value) {
                $this->stmt->bindValue($i, $value);
                $i++;
            }

            $j = 0;
            // Adiciona os valores da condição no bind value
            while ($j < count($where_val)) {
                $this->stmt->bindValue($i, $where_val[$j]);
                $i++;
                $j++;
            }

            $result = $this->stmt->execute();
        } else {
            throw new DaoException("Erro de conexão " . $this->con->errorInfo()[2]);
        }

        $this->autoCloseDB();

        return $result;
    }

    /**
     * Delete
     *
     * @param string $tabela Nome da tabela para aplicar o delete
     * @param string $where_con As condições para seleção
     * @param array $where_val Os valores para substituir os "?" da condição
     * @param string|int $limit Limite do delete
     *
     * @return bool
     * @throws DaoException
     */
    protected function delete(string $tabela, string $where_con = null, array $where_val = [], $limit = null) {
        $this->autoOpenDB();

        // Valida para evitar problemas com sql injection
        if (!$this->checkLimit($limit)) {
            throw new DaoException("Parâmetro limit inválido.");
        }

        // Prepara query
        $sql = "DELETE FROM " . $tabela;
        $sql .= ($where_con != null) ? " WHERE " . $where_con : "";
        $sql .= ($limit != null) ? " LIMIT " . $limit : "";

        // Guarda sql para depuração
        $this->last_sql = $sql;

        if ($this->stmt = $this->con->prepare($sql)) {
            $i = 1;
            // Adiciona os valores da condição no bind value
            while ($i <= count($where_val)) {
                $this->stmt->bindValue($i, $where_val[$i - 1]);
                $i++;
            }

            $result = $this->stmt->execute();
        } else {
            throw new DaoException("Erro de conexão " . $this->con->errorInfo()[2]);
        }

        $this->autoCloseDB();

        return $result;
    }
}