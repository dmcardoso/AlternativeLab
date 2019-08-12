<?php

/**
 * Class ToExtend
 */
class ToExtend {

    protected static $name;

    /**
     * ToExtend constructor.
     * @param $name
     * @param $sobrenome
     */
    public function __construct($name = '') {
        if(!isset(self::$name)){
            self::$name = $name;
        }
    }
}

/**
 * Class Extended
 */
class Extended extends ToExtend {

    public function __construct($name = '') {
        parent::__construct($name);
    }

    public static function getThis(){
        echo "<pre>";
        print_r(self::$name);
        echo "<br>";
    }
}

$obj = new Extended("daniel");
$obj->getThis();
$obj = new Extended();
$obj->getThis();
