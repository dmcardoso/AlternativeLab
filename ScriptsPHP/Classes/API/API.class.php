<?php
/**
 * Created by PhpStorm.
 * User: Daniel Moreira
 * Date: 05/11/2018
 * Time: 16:49
 */

namespace App\API;

use App\Core\Router;
use Exception;

class API {

    const MODULE = __NAMESPACE__;

    private $returns;

    public function render($data) {
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $index => $value) {
                if (isset($value['action'])) {
                    $this->returns[$index] = $this->requestAPI($value['api'], $value['action'], $value);
                } else {
                    $this->returns[$index] = "Nenhuma ação passsada para a API: {$value['api']} em {$index}";
                }
            }
        } else {
            throw new Exception("Dados para API devem ser um array");
        }

        return $this->returnsAPI();
    }

    protected function requestAPI($api, $action, $data) {
        try {
            $rt = new Router(['namespace' => self::MODULE, 'file' => $api, 'method' => $action]);

            if ($rt->methodAndClassExists()) {
                $objetClass = $rt->getClassInstance();
                unset($data['api'], $data['action']);
                return call_user_func_array([new $objetClass(), $rt->getMethod()], [$data]);
            } else {
                return "Ação {$action} não encontrada em {$rt->getClassInstance()}";
            }

        } catch (Exception $e) {
            throw new Exception("Não foi possível carregar a API: {$e}");
        }
    }

    protected function returnsAPI() {
        if(count($this->returns) <= 1){
            $this->returns = $this->returns[array_keys($this->returns)[0]];
        }
        if (is_array($this->returns)) {
            return json_encode($this->returns);
        } else if (is_string($this->returns)) {
            return $this->returns;
        } else {
            return false;
        }
    }

}