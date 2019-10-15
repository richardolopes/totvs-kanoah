<?php

namespace Kanoah\Model;

use \Kanoah\Model;
use \Kanoah\Model\Tabela;
use \Kanoah\BD\SQLServer;

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


	public static function compararParametros($rotina) {
		$parametrosRotina = Parametro::listParametrosRotina($rotina);
		$parametrosQuery  = "";
		$parametrosBase   = array();
		$parametrosKanoah = array();

		foreach ($parametrosRotina as $chave => $valor) {
			$parametrosQuery .= "'" . $chave . "',";
			$parametrosBase[trim($chave)] = $valor;
		}

		$parametrosQuery = substr($parametrosQuery, 0, strlen($parametrosQuery)-1);

		$sql = new SQLServer();
		$paramsUsuario = $sql->select("SELECT X6_VAR, X6_CONTEUD FROM SX6T10 WHERE X6_VAR IN ($parametrosQuery)");

		while (odbc_fetch_row($paramsUsuario)) {
			$parametro = trim(odbc_result($paramsUsuario, "X6_VAR"));
			$valor     = trim(odbc_result($paramsUsuario, "X6_CONTEUD"));

			$valorBase = $parametrosBase[$parametro];

			if ($valorBase != $valor) {
				$parametrosKanoah[$parametro] = $valor;
			}
		}

		echo json_encode($parametrosKanoah);

	}
}
