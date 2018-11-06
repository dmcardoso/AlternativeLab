<?php
/**
 * Created by PhpStorm.
 * User: Daniel Moreira
 * Date: 05/11/2018
 * Time: 10:24
 */

namespace App\Core;

use App\API\Essa;
use App\Core\Res\ResFunctions;
use Exception;

class Router {

    private $path;

    public function __construct($atributes = []) {
        if (isset($atributes['namespace'], $atributes['file'])) {
            $this->path($atributes['namespace'], $atributes['file']);
        } else {
            throw new Exception("Namespace e Classe não definidos.");
        }
        if (isset($atributes['method'])) {
            $this->method($atributes['method']);
        } else {
            throw new Exception("Método não definido.");
        }
    }

    protected function path($namespace, $file) {
        $file = preg_replace('/[^a-zA-Z]/i', '', ucwords(strtolower($file)));
        $namespace_path = trim(str_replace('/', '\\', $namespace));
        $file_path = trim(str_replace('/', '\\', "{$file}"));

        $this->path['class'] = "\\". $namespace_path . "\\" . $file_path . ".php";
        $this->path['instance'] = "\\". $namespace_path . "\\" . $file_path;
    }

    protected function method($method) {
        $this->path['method'] = ResFunctions::attrToCamel($method);
    }

    public function getPathClass() {
        return $this->path['class'];
    }

    public function getClassInstance() {
        return $this->path['instance'];
    }

    public function getMethod() {
        return $this->path['method'];
    }

    public function classExists() {
        return class_exists($this->path['instance']);
    }

    public function methodExists($object) {
        return method_exists($object, $this->path['method']);
    }

    public function methodAndClassExists() {
        if ($this->classExists()) {
            $objectClass = $this->getClassInstance();
            $object = new $objectClass();

            if (method_exists($object, $this->path['method'])) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new Exception("Classe {$this->getClassInstance()} não existe");
        }
    }

}