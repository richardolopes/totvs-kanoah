<?php

namespace Kanoah\Model;

use \Kanoah\Model;		
use \Kanoah\BD\MySQL;
use \Kanoah\BD\SQLServer;
use \Kanoah\BD\SQLCongelada;

class User extends Model
{
    const SESSION = "User";
    const ERROR   = "UserError";

    public static function setError($msg)
    {
        $_SESSION[User::ERROR] = $msg;

        header("Location: /");
        exit;
    }

    public static function getError()
    {
        $msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : "";
        User::clearError();
        return $msg;
    }

    public static function clearError()
    {
        $_SESSION[User::ERROR] = null;
	}

	public static function attSx3()
	{
		set_time_limit(500);

		$sql = new SQLCongelada();
		$mysql = new MySQL();

		$tabelas = $mysql->select("SELECT tabela FROM tabela");

		for ($i = 0; $i < count($tabelas); $i++) {
			$existeTabela = $mysql->select("SELECT id FROM `sx3` WHERE tabela = :TABELA ", array(
				":TABELA" => $tabelas[$i]["tabela"],
			));

			if (!isset($existeTabela[0])) {
				$return = $sql->select("SELECT
					X3_ARQUIVO as tabela, 
					X3_CAMPO as campo, 
					X3_TITULO as titulo, 
					X3_FOLDER as pasta, 
					X3_ORDEM as ordem 	
					FROM SX3T10 WHERE X3_ARQUIVO = '" . $tabelas[$i]['tabela'] . "' ORDER BY X3_ORDEM");

				while (odbc_fetch_row($return)) {
					$tabela = odbc_result($return, "tabela");
					$campo  = odbc_result($return, "campo");
					$titulo = odbc_result($return, "titulo");
					$pasta  = odbc_result($return, "pasta");
					$ordem  = odbc_result($return, "ordem");

					$campos = $mysql->select("SELECT id FROM `sx3` WHERE tabela = :TABELA AND campo = :CAMPO AND titulo = :TITULO", array(
						":TABELA" => $tabela,
						":CAMPO"  => $campo,
						":TITULO" => $titulo
					));
		
					$mysql->query("INSERT INTO `sx3`(`tabela`, `campo`, `titulo`, `pasta`, `ordem`) VALUES (
					:TABELA, 
					:CAMPO, 
					:TITULO, 
					:PASTA, 
					:ORDEM)", array(
						":TABELA" => $tabela,
						":CAMPO"  => $campo,
						":TITULO" => $titulo,
						":PASTA"  => $pasta,
						":ORDEM"  => $ordem
					));
				}
			}
		}

		User::sx3();
	}
	
	public static function sx3()
	{
		$mysql  = new MySQL();
		$return = $mysql->select("SELECT tabela, campo, titulo, pasta, ordem FROM SX3");

		for ($i = 0; $i < count($return); $i++) {
			$GLOBALS["sx3"][trim($return[$i]["campo"])] = utf8_encode($return[$i]["titulo"]);
		}
	}
}
