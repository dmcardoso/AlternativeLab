<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 05/11/2018
 * Time: 16:49
 */

class API {

    const MODULE = __NAMESPACE__;

    private $returns;

    public function render($data) {
        if (is_array($data)) {
            if (isset($data['action'])) {
                $this->requestAPI($data['api'], $data['action'], $data);
            } else {
                throw new Exception("Nenhuma ação passsada para a API");
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
                $this->returns = call_user_func_array([new $rt->getPathClass(), $rt->getMethod()], [$data]);
            } else {
                $this->returns = "Ação não encontrada";
            }

        } catch (Exception $e) {
            throw new Exception("Não foi possível carregar a API \n {$e}");
        }
    }

    protected function returnsAPI() {
        if (is_array($this->returns)) {
            return json_encode($this->returns);
        } else if (is_string($this->returns)) {
            return $this->returns;
        } else {
            return false;
        }
    }

}