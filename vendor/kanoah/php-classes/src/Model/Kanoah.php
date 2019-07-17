<?php

namespace Kanoah\Model;

use \Kanoah\Model;
use \Kanoah\Model\Tabela;

class Kanoah extends Model
{
    public function gerarKanoah($tabelasRotina = array()): array
    {
        if (!empty($tabelasRotina))
        {
            $textoPre = "";
            $textoRes = "";
            $texto    = array(
                "precondicao" => array(),
                "resultado"   => array(),
            );

            for ($i = 0; $i < count($tabelasRotina["precondicao"]); $i++)
            {
                foreach ($tabelasRotina["precondicao"][$i] as $key => $value)
                {
                    if (!empty($_POST["PRE" . $key . "QUERY"]) && !empty($_POST["PRE" . $key . "WHERE"]))
                    {
                        $textoPre .= Tabela::infTabelas($_POST["PRE" . $key . "QUERY"] . " WHERE " . $_POST["PRE" . $key . "WHERE"]);
                    }
                    else
                    {
                        User::setError("EMPTY_POSTPRE QUERY/WHERE");
                    }
                }
            }

            for ($i = 0; $i < count($tabelasRotina["resultado"]); $i++)
            {
                foreach ($tabelasRotina["resultado"][$i] as $key => $value)
                {
                    if (!empty($_POST["RES" . $key . "QUERY"]) && !empty($_POST["RES" . $key . "WHERE"]))
                    {
                        $textoRes .= Tabela::infTabelas($_POST["RES" . $key . "QUERY"] . " WHERE " . $_POST["RES" . $key . "WHERE"]);
                    }
                    else
                    {
                        User::setError("EMPTY_POSTRES QUERY/WHERE");
                    }
                }
            }

            array_push($texto["precondicao"], $textoPre);
            array_push($texto["resultado"], $textoRes);

            return $texto;
        }
        else
        {
            User::setError("EMPTY_QUERYS");
        }
    }
}
