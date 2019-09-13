<?php

namespace Kanoah\Model;

use \Kanoah\BD\MySQL;
use \Kanoah\BD\SQLServer;
use \Kanoah\Model;

/*
0 - PRE CONDICOES
1 - RESULTADO ESPERADO
 */

class Tabela extends Model
{
    public static function listTabelas(): array
    {
        $mysql = new MySQL();

        return $mysql->select("SELECT tabela FROM tabela ORDER BY tabela ASC");
	}
	
	public function tabela($tabela = string)
    {
        if (!empty($tabela))
        {
            $mysql = new MySQL();

            $data = $mysql->select("SELECT id, tabela, nome, query FROM tabela WHERE tabela = :TABELA", array(
                ":TABELA" => $tabela,
            ));

            $this->setData($data[0]);
        }
        else
        {
            User::setError("EMPTY_TABELA");
        }
	}

	public function relacaoTabela($tabela = string): array
	{
		if (!empty($tabela))
        {
            $mysql = new MySQL();

            return $mysql->select("SELECT TAB.tabela, TAB2.tabela, TABREL.campo, TABREL.camporel FROM tabela AS TAB INNER JOIN tabela_relacao AS TABREL ON TABREL.idtabela = TAB.id INNER JOIN tabela AS TAB2 ON TAB2.id = TABREL.idrelacao WHERE TAB.tabela = :TABELA ", array(
                ":TABELA" => $tabela,
			));	
        }
        else
        {
            User::setError("EMPTY_TABELA");
        }
	}

    public static function listTabelasRotina($rotina = string): array
    {
        if (!empty($rotina))
        {
            $mysql = new MySQL();

            $precondicao = $mysql->select("SELECT tabela, query FROM tabela as TAB inner join rotina_tabela as ROTTAB on ROTTAB.idtabela = TAB.id inner join rotina as ROT on ROT.id = ROTTAB.idrotina where ROT.rotina = :ROTINA AND tipo = 0", array(
                ":ROTINA" => $rotina,
            ));

            $resultado = $mysql->select("SELECT tabela, query FROM tabela as TAB inner join rotina_tabela as ROTTAB on ROTTAB.idtabela = TAB.id inner join rotina as ROT on ROT.id = ROTTAB.idrotina where ROT.rotina = :ROTINA AND tipo = 1", array(
                ":ROTINA" => $rotina,
            ));

            $tabelas = array(
                "precondicao" => array(),
                "resultado"   => array(),
            );

            foreach ($precondicao as $value)
            {
                array_push($tabelas["precondicao"], array(
                    $value["tabela"] => $value["query"],
                ));
            }

            foreach ($resultado as $value)
            {
                array_push($tabelas["resultado"], array(
                    $value["tabela"] => $value["query"],
                ));
            }

            return $tabelas;
        }
        else
        {
            throw new \Exception("EMPTY_ROTINA");
        }
    }

    public static function infTabelas($query = string): string
    {
        $sql    = new SQLServer();
        $string = "";

        $return = $sql->select($query);

        while (odbc_fetch_row($return))
        {
            for ($j = 1; $j <= odbc_num_fields($return); $j++)
            {
                $field_name = odbc_field_name($return, $j);
                $sx3        = $sql->select("SELECT X3_TITULO FROM SX3T10 WHERE X3_CAMPO = '$field_name'");

                $string .= str_pad($field_name, 10) . " (" . odbc_result($sx3, "X3_TITULO") . ") = '" . odbc_result($return, $field_name) . "'\n";
            }

            $string .= "\n\n";
        }

        return utf8_encode($string);
	}
	
	public static function criarTabela($tabela = string, $nome = string, $query = string)
	{
		if (!empty($tabela) && !empty($query)) {
			$tabela = strtoupper($tabela);
			$query  = strtoupper($query);

			$sql = new SQLServer();
			$sql->select($query . " WHERE R_E_C_N_O_ = 0");
			$sql->select("SELECT * FROM " . $tabela . "T10 WHERE R_E_C_N_O_ = 0");
			
			if (empty($nome)) {
				$return = $sql->select("SELECT X2_NOME FROM SX2T10 WHERE X2_CHAVE = '" . $tabela . "' ");

				$nome = odbc_result($return, "X2_NOME");
			}

			$mysql = new MySQL();
			$mysql->query("INSERT INTO tabela(`tabela`, `nome`, `query`) VALUES (:TABELA, :NOME, :QUERY)", array(
				":TABELA"=>$tabela,
				":NOME"=>$nome,
				":QUERY"=>$query
			));
		} else {
			User::setError("EMPTY_CRIARTABELA");
		}
	}

	public static function ajustarTabelas($tabelasRotina):array
	{
		$tabs = array();
		foreach ($tabelasRotina as $key => $value) {
			foreach ($value as $chave => $e) {
				array_push($tabs, $chave);
			}
		}

		return $tabs;
	}


	public function addTabRot($rotina = int, $tabelas = array(), $tipo = int)
	{
		$mysql = new MySQL();

		foreach ($tabelas as $key => $value) {
			$retTab = $mysql->select("SELECT id FROM tabela WHERE tabela = :TABELA", array(
				":TABELA"=>$value
			));

			$return = $mysql->select("SELECT id FROM rotina_tabela WHERE idrotina = :ROTINA AND idtabela = :TABELA AND tipo = :TIPO", array(
				":ROTINA" => $rotina,
				":TABELA" => $retTab[0]["id"],
				":TIPO"   => $tipo
			));


			if (!isset($return[0])) {
				$mysql->query("INSERT INTO rotina_tabela(`idrotina`, `idtabela`, `tipo`) VALUES (:ROTINA, :TABELA, :TIPO)", array(
					":ROTINA" => $rotina,
					":TABELA" => $retTab[0]["id"],
					":TIPO"   => $tipo
				));
			} else {
				User::setError("TABELA_JA_CADASTRADA");
			}
		}
	}
}
