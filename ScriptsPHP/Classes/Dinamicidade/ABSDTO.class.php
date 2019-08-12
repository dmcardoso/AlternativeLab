<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 01/11/2018
 * Time: 16:02
 */

abstract class ABSDTO {

    private $attr = [];

    protected function set($property = null, $value = null) {
        if (isset($property, $value) && $property != null && $value != null) {
            if (!in_array($property, array_keys($this->attr))) {
                $this->attr[$property] = $value;
                return true;
            } else {
                throw new Exception("Propiedade {$property} já existe na classe");
            }
        } else {
            throw new Exception("Propiedade ou valor não podem ser nulos");
        }
    }

    protected function get($name) {
        if (in_array($name, array_keys($this->attr))) {
            return $this->attr[$name];
        } else {
            throw new Exception("Atributo {$name} inexistente");
        }
    }


    public function __call($name, $arguments) {
        $method = substr($name, 0, 3);
        $attr = lcfirst(substr($name, 3));

        if (method_exists($this, $method)) {
            if ($method == "set") {
                return $this->$method(ResFunctions::camelToAttr($attr), $arguments[0]);
            } elseif ($method == "get") {
                return $this->$method(ResFunctions::camelToAttr($attr));
            }
        } elseif (method_exists($this, $name)) {
            return $this->$name($arguments);
        } else {
            throw new Exception("Método {$name} inválido");
        }
        return false;
    }

    public function __get($name) {
        throw new Exception("Atributo {$name} privado deve ser acessado por método get");
    }

    public function __set($name, $attr) {
        throw new Exception("Impossível criar atributo {$name}, utilize o método set");
    }

    public function getProperties() {
        if (count($this->attr) > 0) {
            return $this->attr;
        } else {
            throw new Exception("Objeto não possui atributos");
        }
    }

    public function clear() {
        if (count($this->attr) > 0) {
            unset($this->attr);
            return true;
        } else {
            throw new Exception("Objeto não possui atributos");
        }
    }

}