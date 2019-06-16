<?php

namespace Kanoah\Model;

use \Kanoah\BD\Sql;
use \Kanoah\Model;

class Tabela extends Model {
	public function Teste() {			
		$sql = new Sql();

		$return = $sql->select("SELECT * FROM SE1T10 WHERE E1_PREFIXO = 'RIC'");

		var_dump($return);

		while (odbc_fetch_row($return)) {
			echo "" . odbc_result($return, "E1_NUM")."<BR>";
			echo "<hr>";
			echo "" . odbc_result($return, "E1_TIPO")."<BR>";       
		}
	}

	public static function retornarQuerys($tabela) {
		// retornar a tabela e as query para pesquisa e resultado esperado
		$array = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . TABELAS . DIRECTORY_SEPARATOR . $tabela . ".JSON"), true);

		return $array["QUERYS"];
	}

	public static function retornarCampos($tabela) {
		// retornar a tabela e as query para pesquisa e resultado esperado
		$array = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . TABELAS . DIRECTORY_SEPARATOR . $tabela . ".JSON"), true);

		return $array["CAMPOS"];
	}
}
