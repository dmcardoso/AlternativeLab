<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 03/10/2018
 * Time: 16:59
 */

class Formulario {

    private $inputs = [], $form_dados, $buttons;

    private $class_css = [
        "class_form" => " form",
        "text" => " texet",
        "select" => " select",
        "date" => " date",
        "password" => " pass",
        "number" => " n",
        "email" => " e",
        "color" => " c",
        "phone" => " p",
    ];

    public function __construct($dados = []) {
        if (!is_array($dados)) {
            throw new Exception("Parâmetro inválido. Formulário informado deve ser um array!");
        } else if (!isset($dados['name'])) {
            throw new Exception("Formulário exige propiedade name!");
        } else {
            $this->form_dados = $this->formProperties($dados);
        }
    }

    private function formProperties($propiedades = []) {
        $retorno = [];
        if (!is_array($propiedades)) {
            throw new Exception("Parâmetro inválido. Propiedades do formulário informado deve ser um array!");
        } else {
            if (isset($propiedades['name'])) $retorno['name'] = $propiedades['name'];
            if (isset($propiedades['id'])) $retorno['id'] = $propiedades['id'];
            if (isset($propiedades['method'])) $retorno['method'] = $propiedades['method'];
            if (isset($propiedades['action'])) $retorno['action'] = $propiedades['action'];
            if (isset($propiedades['class'])) $retorno['class'] = $propiedades['class'];
        }

        return $retorno;
    }

    public function setInput($input = []) {
        if (!is_array($input)) {
            throw new Exception("Parâmetro inválido. Input informado deve ser um array!");
        }
        if (count($input) > 0) {
            $this->inputs[] = $this->inputProperties($input);
        }
    }

    private function inputProperties($propiedades = []) {
        $retorno = [];
        if (!is_array($propiedades)) {
            throw new Exception("Parâmetro inválido. Propiedades do input informado deve ser um array!");
        } else if (!isset($propiedades['type'])) {
            throw new Exception("Parâmetro inválido. Type do input não informado!");
        } else if (!isset($propiedades['id']) && !isset($propiedades['name'])) {
            throw new Exception("Parâmetro inválido. Input necessita de id ou name!");
        } else {
            if ($propiedades['type'] == "hidden") {
                if (isset($propiedades['name'])) $retorno['name'] = $propiedades['name'];
                if (isset($propiedades['id'])) $retorno['id'] = $propiedades['id'];
                if (isset($propiedades['label'])) $retorno['label'] = $propiedades['label'];
                if (isset($propiedades['class'])) $retorno['class'] = $propiedades['class'];
                if (isset($propiedades['value'])) $retorno['value'] = $propiedades['value'];
            } else if ($propiedades['type'] == "select") {
                if (isset($propiedades['name'])) $retorno['name'] = $propiedades['name'];
                if (isset($propiedades['id'])) $retorno['id'] = $propiedades['id'];
                if (isset($propiedades['label'])) $retorno['label'] = $propiedades['label'];
                if (isset($propiedades['class'])) $retorno['class'] = $propiedades['class'];
                if (isset($propiedades['options'])) $retorno['options'] = $this->addOptions($propiedades['options']);
                if (isset($propiedades['type'])) $retorno['type'] = $propiedades['type'];
            } else {
                if (isset($propiedades['name'])) $retorno['name'] = $propiedades['name'];
                if (isset($propiedades['label'])) $retorno['label'] = $propiedades['label'];
                if (isset($propiedades['id'])) $retorno['id'] = $propiedades['id'];
                if (isset($propiedades['class'])) $retorno['class'] = $propiedades['class'];
                if (isset($propiedades['type'])) $retorno['type'] = $propiedades['type'];
                if (isset($propiedades['value'])) $retorno['value'] = $propiedades['value'];
                if (isset($propiedades['placeholder'])) $retorno['placeholder'] = $propiedades['placeholder'];
            }
        }

        return $retorno;
    }

    public function addOptions($options = []) {
        $retorno = [];
        if (!is_array($options)) {
            throw new Exception("Parâmetro inválido. Options do select informado deve ser um array!");
        }
        if (count($options) > 0) {
            foreach ($options as $i => $v) {
                if (!isset($v['value']) && !isset($v['label'])) throw new Exception("Option deve haver value e label");
                if (isset($v['selected'])) $retorno[$i]['selected'] = 'selected';
                $retorno[$i]['value'] = $v['value'];
                $retorno[$i]['label'] = $v['label'];
            }
        }

        return $retorno;
    }

    public function getOptions_html($options) {
        $html = "";
        if (is_array($options)) {
            foreach ($options as $i => $v) {
                $html .= "<option value='" . $v['value'] . "' " . ((isset($v['selected'])) ? 'selected' : '') . ">" . $v['label'] . "</option>";
            }
            return $html;
        } else {
            throw new Exception("Parâmetro inválido. Options do select informado deve ser um array!");
        }
    }

    public function getInputs($html = false) {
        if ($html) {
            $html = "";
            foreach ($this->inputs as $i => $v) {
                if (isset($v['type']) && $v['type'] == "select") {
                    $html .= '<select ' . ((isset($v['name'])) ? 'name="' . $v['name'] . '" ' : '') . ((isset($v['id'])) ? 'id="' . $v['id'] . '"' : '') . '>';
                    $html .= $this->getOptions_html($v['options']);
                    $html .= '</select>';
                } else {
                    $html .= '<input type="' . $v['type'] . '" ' . ((isset($v['name'])) ? 'name="' . $v['name'] . '" ' : '') . ((isset($v['id'])) ? 'id="' . $v['id'] . '" ' : '') . ((isset($v['value'])) ? 'value="' . $v['value'] . '" ' : '') . ((isset($v['placeholder'])) ? 'placeholder="' . $v['placeholder'] . '" ' : '') . ((isset($v['class'])) ? 'class="' . $v['class'] . $this->class_css[$v['type']] . '" ' : 'class="' . $this->class_css[$v['type']] .'" ') . '>';
                }
            }

            return $html;
        } else {
            return $this->inputs;
        }
    }

    public function render() {
        $html = "<form " . ((isset($this->form_dados['name'])) ? 'name="' . $this->form_dados['name'] . '" ' : '') . ((isset($this->form_dados['id'])) ? 'id="' . $this->form_dados['id'] . '" ' : '') . ((isset($this->form_dados['class'])) ? 'class="' . $this->form_dados['class'] . $this->class_css['class_form'] . '" ' : 'class="' . $this->class_css['class_form'] .'" ') . ((isset($this->form_dados['method'])) ? 'method="' . $this->form_dados['method'] . '" ' : '') . ((isset($this->form_dados['action'])) ? 'action="' . $this->form_dados['action'] . '" ' : '') . ">";
        $html .= $this->getInputs(true);
        $html .= "</form>";

        echo $html;
    }

}