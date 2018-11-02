<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 01/11/2018
 * Time: 16:02
 */

require 'ABSDTO.class.php';

class Dinamicidade extends ABSDTO {

    public function __construct($data = null) {
        if ($data != null && is_array($data)) {
            foreach ($data as $i => $v) {
                $this->set($i, $v);
            }
        }
    }
}