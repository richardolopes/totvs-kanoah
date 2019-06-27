<?php

namespace Kanoah\Model;

use \Kanoah\Model;
use \Kanoah\BD\SQLServer;

class Tabela extends Model {
	public static function Teste() {			
		$sql = new SQLServer();

		$return = $sql->select("SELECT * FROM SE1T10 WHERE E1_PREFIXO = '001' ");

		while (odbc_fetch_row($return)) {
			echo "" . odbc_result($return, "E1_NUM")."<BR>";
			echo "<hr>";
			// echo "" . odbc_result($return, "E1_TIPO")."<BR>";       
		}
	}

	public function infTabelas($tabelas = array()):array {
		$infTabelas = array();
		
		foreach ($tabelas as $tabela) {
			$diretorio = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . TABELAS . DIRECTORY_SEPARATOR . $tabela . ".JSON";

			$array = json_decode(file_get_contents($diretorio), true);
	
			array_push($infTabelas, $array);
		}

		return $infTabelas;
	}
}
