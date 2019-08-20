<?php

namespace Kanoah;

// Classe para gerar automaticamente os getters e setters.
class Model
{
    // Todos os valores dos campos que temos dentro do objeto.
    private $values = array();

    // $name -> Nome do metodo.
    // $args -> Parametros do metodo.
    public function __call($name, $args)
    {
        // Get ou Set.
        $method = substr($name, 0, 3);

        // Nome do campo.
        $fieldName = substr($name, 3, strlen($name));

        switch ($method)
        {
            case "get":
                // Procura o campo no values.
                // Se encontrar retorna o proprio campo.
                return isset($this->values[$fieldName]) ? utf8_encode($this->values[$fieldName]) : null;
                break;

            case "set":
                // Procura o campo no values e aplica o valor.
                $this->values[$fieldName] = $args[0];
                break;
        }
    }

    // Metodo para criar o set de cada campo.
    public function setData($data = array())
    {
        foreach ($data as $key => $value)
        {
            $this->{"set" . strtolower($key)}($value);
        }
    }

    public function getValues()
    {
        return $this->values;
    }
}
