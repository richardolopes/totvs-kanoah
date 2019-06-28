<?php

namespace Kanoah\Model;

use \Kanoah\Model;
use \Kanoah\BD\SQLServer;

class Tabela extends Model {
	public static function infTabelas($query = string):string {
		$sql = new SQLServer();

		$string = "";
		
		$return = $sql->select($query);

		while (odbc_fetch_row($return) ) {
			for ($j = 1; $j <= odbc_num_fields($return); $j++) {        
				$field_name = odbc_field_name($return, $j);

				$sx3 = $sql->select("SELECT X3_TITULO FROM SX3T10 WHERE X3_CAMPO = '$field_name'");
				
				$string .= str_pad($field_name, 10) . " (" . odbc_result($sx3, "X3_TITULO") . ") = '" . odbc_result($return, $field_name) . "'\n";

			}
			$string .= "\n\n";
		}

		return $string;
	}
}
