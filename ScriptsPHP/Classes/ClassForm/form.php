<?php
/**
 * Created by PhpStorm.
 * User: qualq
 * Date: 03/10/2018
 * Time: 17:03
 */

require "Formulario.php";

$form = new Formulario(['name' => 'formulario_teste']);

$form->setInput(['tipo' => "input_select",'id' => "input1", 'name' => "pessoa", 'value' => "Daniel", 'type' => 'select', 'options' => [['value' => 1, 'label' => 'Daniel'], ['value' => 2, 'label' => 'Paulo', "selected" => true]]]);
$form->setInput(['tipo' => "input_text",'id' => "input1", 'name' => "pessoa", 'type' => 'text', 'options' => [['value' => 1, 'label' => 'Daniel', "selected" => true], ['value' => 2, 'label' => 'Paulo']]]);
$form->setInput(['tipo' => "input_text", 'type' => 'date','id' => "input1", 'name' => "pessoa", 'value' => "Daniel", 'options' => [['value' => 1, 'label' => 'Daniel', "selected" => true], ['value' => 2, 'label' => 'Paulo']]]);
$form->setInput(['tipo' => "input_text", 'type' => 'password','id' => "input1", 'name' => "pessoa", 'value' => "Daniel", 'options' => [['value' => 1, 'label' => 'Daniel', "selected" => true], ['value' => 2, 'label' => 'Paulo']]]);
$form->setInput(['tipo' => "input_text", 'type' => 'color','id' => "input1", 'name' => "pessoa", 'value' => "Daniel", 'options' => [['value' => 1, 'label' => 'Daniel', "selected" => true], ['value' => 2, 'label' => 'Paulo']]]);
$form->setInput(['tipo' => "input_text", 'type' => 'email','id' => "input1", 'name' => "pessoa", 'value' => "Daniel", 'options' => [['value' => 1, 'label' => 'Daniel', "selected" => true], ['value' => 2, 'label' => 'Paulo']]]);
$form->setInput(['tipo' => "input_text", 'type' => 'number','id' => "input1", 'name' => "pessoa", 'value' => "Daniel", 'options' => [['value' => 1, 'label' => 'Daniel', "selected" => true], ['value' => 2, 'label' => 'Paulo']]]);
$form->setInput(['tipo' => "input_text", 'type' => 'phone','id' => "input1", 'name' => "pessoa", 'value' => "Daniel", 'options' => [['value' => 1, 'label' => 'Daniel', "selected" => true], ['value' => 2, 'label' => 'Paulo']]]);

?>
<html>
<head></head>
<body></body>
    <?php $form->render(); ?>
</html>
