<?php
/**
 * Created by PhpStorm.
 * User: Daniel Moreira
 * Date: 09/05/2018
 * Time: 23:18
 */

namespace App\Models\DAO;

use Exception;
use PDO;
use PDOException;

abstract class DAOBase {

    private $conexao, $ultimaQuery;

    private $dadosConexao = [
        "driver" => "mysql",
        "host" => "localhost",
        "db" => "academico",
        "user" => "root",
        "password" => "1234"
    ];

    const TYPE_UNQ = 1;
    const TYPE_MTPL = 2;

    public function __construct() {
    }

    public function configConexao() {
        if ($this->conexao == null) {
            $dsn = $this->dadosConexao['driver'] . ':host=' . $this->dadosConexao['host'] . ";dbname=" . $this->dadosConexao['db'];
            $user = $this->dadosConexao['user'];
            $password = $this->dadosConexao['password'];
            try {
                $pdo = new PDO($dsn, $user, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $ex) {
                throw new Exception("Erro ao conectar-se ao banco de dados! " . $ex->getMessage());
            }
        } else {
            throw new Exception("Conexão já estabelecida");
        }
    }

    public function insert($tabela, $campos = [], $tipoInsert = self::TYPE_UNQ) {
        $sql = "";
        $indices = [];
        $bind = [];
        $quantidadeCampos = count($campos);
        $id = 0;
        if (!empty($tabela) && count($campos) > 0) {
            $sql .= "INSERT INTO " . $tabela . "(";
            if ($tipoInsert == self::TYPE_UNQ) {
                foreach ($campos as $indice => $valor) {
                    $indices[] = $indice;
                    $bind[] = "?";
                }

                $indices = $this->bindParams($indices, ", ");
                $bind = $this->bindParams($bind, ",");

                $sql .= $indices . ") values (" . $bind . ")";

                $this->ultimaQuery = $sql;

            } else if ($tipoInsert == self::TYPE_MTPL) {
                $indicesInsert = [];
                if (isset($campos[0])) {
                    foreach ($campos[0] as $i => $v) {
                        $indicesInsert[] = $i;
                        $bind[] = "?";
                    }
                }

                $indicesInsert = $this->bindParams($indicesInsert, ", ");
                $bind = $this->bindParams($bind, ",");

                $sql .= $indicesInsert . ") values ";

                $bindMultiple = [];

                foreach ($campos as $i => $objeto) {
                    $bindMultiple[] = "(" . $bind . ")";
                }

                $bindMultiple = $this->bindParams($bindMultiple, ",");

                $sql .= $bindMultiple;

            }
        } else {
            throw new Exception("Dados inválidos!");
        }

        try {
            $this->conexao = $this->configConexao();
            $query = $this->conexao->prepare($sql);


            if ($tipoInsert == self::TYPE_UNQ) {
                foreach (array_keys($campos) as $indice => $chave) {
                    $query->bindValue(($indice + 1), $campos[$chave]);
                }
            } else if ($tipoInsert == self::TYPE_MTPL) {
                $i = 1;
                foreach ($campos as $indice => $objeto) {
                    foreach ($objeto as $idx => $valor) {
                        $query->bindValue($i, $valor);
                        $i++;
                    }
                }
            }

            $query->execute();
            $id = $this->conexao->lastInsertId();
        } catch (PDOException $ex) {
            throw new Exception("Falha ao inserir " . $ex->getMessage());
        } catch (Exception $e) {
            throw new Exception("Falha ao alterar " . $e->getMessage());
        } finally {
            $this->endConexao($this->conexao);
            print_r($this->conexao);
        }
        return $id;
    }

    public function update($tabela, $campos = [], $condicao = [], $whereval = []) {
        $sql = "";
        $retorno = 0;
        $bindUpdate = [];
        $quantidadeUpdate = 0;
        $bindCondicao = [];
        if (!empty($tabela) && count($campos) > 0 && count($condicao) > 0 && count($whereval) > 0) {
            $sql .= "UPDATE " . $tabela . " set ";

            foreach ($campos as $indice => $valor) {
                $bindUpdate[] = $indice . " = ? ";
            }

            $quantidadeUpdate = count($bindUpdate);

            $bindUpdate = $this->bindParams($bindUpdate, ", ");

            $sql .= $bindUpdate;

            foreach ($condicao as $index => $value) {
                $bindCondicao[] = $value . " ? ";
            }

            $bindCondicao = $this->bindParams($bindCondicao, " ");

            $sql .= " WHERE " . $bindCondicao;

            $this->ultimaQuery = $sql;
        } else {
            throw new Exception("Dados inválidos!");
        }

        try {
            $this->conexao = $this->configConexao();
            $query = $this->conexao->prepare($sql);

            foreach (array_keys($campos) as $indice => $chave) {
                $query->bindValue(($indice + 1), $campos[$chave]);
            }

            foreach ($whereval as $indice => $valor) {
                $query->bindValue(($quantidadeUpdate + 1), $valor);
            }

            $retorno = $query->execute();
        } catch (PDOException $ex) {
            throw new Exception("Falha ao alterar " . $ex->getMessage());
        } catch (Exception $e) {
            throw new Exception("Falha ao alterar " . $e->getMessage());
        } finally {
            $this->endConexao();
        }

        return $retorno;
    }

    public function delete($tabela, $condicao = [], $whereval = [], $limit = null) {
        $sql = "";
        $retorno = 0;
        $bindCondicao = [];
        if (!empty($tabela) && count($condicao) > 0 && count($whereval) > 0) {
            $sql .= "DELETE FROM " . $tabela;

            foreach ($condicao as $index => $value) {
                $bindCondicao[] = $value . " ? ";
            }

            $bindCondicao = $this->bindParams($bindCondicao, " ");

            $sql .= " WHERE " . $bindCondicao;

            if ($limit != null) {
                $sql .= " LIMIT " . $limit;
            }

            $this->ultimaQuery = $sql;
        } else {
            throw new Exception("Dados inválidos!");
        }

        try {
            $this->conexao = $this->configConexao();
            $query = $this->conexao->prepare($sql);

            foreach ($whereval as $indice => $valor) {
                $query->bindValue(($indice + 1), $valor);
            }

            $retorno = $query->execute();
        } catch (PDOException $ex) {
            throw new Exception("Falha ao deletar " . $ex->getMessage());
        } catch (Exception $e) {
            throw new Exception("Falha ao deletar " . $e->getMessage());
        } finally {
            $this->endConexao();
        }

        return $retorno;
    }

    public function select($tabelas, $campos = null, $condicao = [], $whereval = [], $groupby = null, $orderby = null, $limit = null, $having = null) {
        $sql = "";
        $retorno = 0;
        $bindCondicao = [];
        if (!empty($tabelas)) {
            $campos = ($campos != null) ? $campos : " * ";
            $sql .= "SELECT " . $campos . " FROM " . $tabelas;

            if (count($condicao) > 0) {
                foreach ($condicao as $index => $value) {
                    $bindCondicao[] = $value . " ? ";
                }

                $bindCondicao = $this->bindParams($bindCondicao, " ");

                $sql .= " WHERE " . $bindCondicao;
            }

            $sql .= ($groupby != null) ? " GROUP BY " . $groupby . " " : "";
            $sql .= ($having != null) ? " HAVING " . $having . " " : "";
            $sql .= ($orderby != null) ? " ORDER BY " . $orderby . " " : "";
            $sql .= ($limit != null) ? " LIMIT " . $limit : "";

            $this->ultimaQuery = $sql;
        } else {
            throw new Exception("Dados inválidos!");
        }

        try {
            $this->conexao = $this->configConexao();
            $query = $this->conexao->prepare($sql);

            foreach ($whereval as $indice => $valor) {
                $query->bindValue(($indice + 1), $valor);
            }

            $query->execute();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            $retorno = [];

            if (count($result) > 0) {
                if (isset($result[0])) {
                    $retorno = $result;
                } else {
                    $retorno = [$result];
                }
            }

        } catch (PDOException $ex) {
            throw new Exception("Falha ao selecionar " . $ex->getMessage());
        } catch (Exception $e) {
            throw new Exception("Falha ao selecionar " . $e->getMessage());
        } finally {
            $this->endConexao();
        }

        return $retorno;
    }

    public function prepare($sql) {
        $retorno = 0;
        if (trim($sql) != "") {
            $type = $this->starts($sql);
            if ($type == "insert") {
                throw new Exception("Use o método de insert para inserir um registro");
                return $retorno;
            } else if ($type == "delete") {
                throw new Exception("Use o método de delete para excluir um registro");
                return $retorno;
            }
            try {
                $this->conexao = $this->configConexao();
                $query = $this->conexao->prepare($sql);

                if ($type == "select") {
                    $query->execute();

                    $result = $query->fetchAll(PDO::FETCH_ASSOC);

                    $retorno = [];

                    if (count($result) > 0) {
                        if (isset($result[0])) {
                            $retorno = $result;
                        } else {
                            $retorno = [$result];
                        }
                    }
                } else if ($type == "update") {
                    $retorno = $query->execute();
                }

            } catch (PDOException $ex) {
                throw new Exception("Falha ao selecionar " . $ex->getMessage());
            } catch (Exception $e) {
                throw new Exception("Falha ao selecionar " . $e->getMessage());
            } finally {
                $this->endConexao();
            }

            return $retorno;
        }
    }

    private function bindParams($param = [], $glue) {
        if (is_array($param)) return implode($glue, $param);
        else throw new Exception('Impossível criar bind. Parâmetro esperado: array');
    }

    public function endConexao() {
        try {
            unset($this->conexao);
        } catch (PDOException $ex) {
            throw new Exception("Erro ao fechar a conexão!");
        }
    }

    public function starts($sql) {
        if (trim($sql) != "") {
            return strtolower(explode(" ", $sql)[0]);
        } else {
            return false;
        }
    }
}