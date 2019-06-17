<?php

namespace Kanoah\Model;

use \Kanoah\BD\SQLServer;
use \Kanoah\Model;

class Rotina extends Model {
	// Retorna todas as rotinas cadastradas no modulo.
	public static function retornarRotinas($modulo = string) {
		// Diretório das rotinas
		$path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . MODULOS . DIRECTORY_SEPARATOR . $modulo . DIRECTORY_SEPARATOR;
		$diretorio = @dir($path);
	
		$rotinas = array();
	
		if (!empty($diretorio)) {
			// Pulas os diretórios '.' e '..'
			$diretorio->read();
			$diretorio->read();
	
			while($rotina = $diretorio->read()){
				$rotina = explode(".", $rotina); // Retira a extensão .JSON
				array_push($rotinas, $rotina[0]);
			}
	
			$diretorio->close();
	
			return $rotinas;
		} else {
			return ["??"];
		}
	}

	// Define todos os atributos da rotina.
	public function infRotina($modulo = string, $rotina = string) {
		$diretorio = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . MODULOS . DIRECTORY_SEPARATOR . $modulo . DIRECTORY_SEPARATOR . $rotina . ".JSON";

		$array = json_decode(file_get_contents($diretorio), true);

		$this->setData($array);
	}

	public function infTabelasDep($dependencias = array()):array {
		$infDependencias = array();
		$diretorio       = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . TABELAS . DIRECTORY_SEPARATOR;
		
		foreach ($dependencias as $key) {
			$array = json_decode(file_get_contents($diretorio . $key . ".JSON"), true);

			array_push($infDependencias, array(
				"TABELA"    => $key,
				"QUERY"     => $array["QUERY"],
				"REGISTROS" => $array["REGISTROS_DEFINIDOS"]
			
			));
		}

		return $infDependencias;
	}

	public static function retornarMenu($modulo = string, $rotina = string):string {
		$sql = new SQLServer();

		$return = $sql->select("
			SELECT RTRIM(DESCR3.N_DESC) + ' > ' + RTRIM(DESCR2.N_DESC) + ' > ' + RTRIM(DESCR.N_DESC) + ' (' + '$rotina' + ')' AS MENU
			FROM MPMENU_FUNCTION AS ROTINA
			JOIN MPMENU_MENU AS MENU ON MENU.M_NAME = '$modulo'
			JOIN MPMENU_ITEM AS ITEM ON ITEM.I_ID_FUNC = ROTINA.F_ID
				AND ITEM.I_ID_MENU = MENU.M_ID
			JOIN MPMENU_I18N AS DESCR ON DESCR.N_PAREN_ID = ITEM.I_ID
				AND DESCR.N_LANG = '1'
			JOIN MPMENU_ITEM AS ITEM2 ON ITEM2.I_ID = ITEM.I_FATHER
				AND ITEM2.I_ID_MENU = MENU.M_ID
			JOIN MPMENU_I18N AS DESCR2 ON DESCR2.N_PAREN_ID = ITEM2.I_ID
				AND DESCR2.N_LANG = '1'
			JOIN MPMENU_ITEM AS ITEM3 ON ITEM3.I_ID = ITEM2.I_FATHER
				AND ITEM3.I_ID_MENU = MENU.M_ID
			JOIN MPMENU_I18N AS DESCR3 ON DESCR3.N_PAREN_ID = ITEM3.I_ID
				AND DESCR3.N_LANG = '1'
			WHERE ROTINA.F_FUNCTION = '$rotina'
		");

		while (odbc_fetch_row($return)) {
			$menu = odbc_result($return,"MENU");
		}

		return substr($menu, 1, strlen($menu));
	}

}
