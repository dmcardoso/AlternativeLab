<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 05/11/2018
 * Time: 10:50
 */

class ResFunctions {

    public static function camelToStr($str) {
        $matches = "";
        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $str, $matches);
        if (isset($matches[1]) && count($matches[1]) > 0) {
            return ucfirst(strtolower(implode(" ", $matches[1])));
        } else {
            throw new Exception("Frase informada não é Camel Case");
        }
    }

    public static function camelToAttr($str) {
        $matches = "";
        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $str, $matches);
        if (isset($matches[1]) && count($matches[1]) > 0) {
            return strtolower(implode("_", $matches[1]));
        } else {
            throw new Exception("Frase informada não é Camel Case");
        }
    }

    public static function attrToCamel($attr, $method = false) {
        $string = "";
        foreach (explode("_", $attr) as $i => $v) {
            if ($i == 0) {
                if ($method) {
                    $string .= strtolower($method);
                    $string .= ucfirst(strtolower($v));
                } else {
                    $string .= strtolower($v);
                }
            } else {
                $string .= ucfirst(strtolower($v));
            }
        }
        return $string;
    }

}