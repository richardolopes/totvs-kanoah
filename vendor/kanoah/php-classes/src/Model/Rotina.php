<?php

namespace Kanoah\Model;

use \Kanoah\BD\SQLServer;
use \Kanoah\Model;

class Rotina extends Model {
	// Define todos os atributos da rotina.
	public function infRotina($rotina = string) {
		$diretorio = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . ROTINAS . DIRECTORY_SEPARATOR . $rotina . ".JSON";

		$array = json_decode(file_get_contents($diretorio), true);

		$this->setData($array);
	}


	public function retornarQuerys($rotina = string, $tipo = string):array {
		$diretorioRotina = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . ROTINAS . DIRECTORY_SEPARATOR;
		$diretorioTabela = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . TABELAS . DIRECTORY_SEPARATOR;

		$rotinaJSON = json_decode(file_get_contents($diretorioRotina . $rotina . ".JSON"), true);

		$querys = array();
		
		foreach($rotinaJSON["$tipo"] as $tabela) {
			$tabelaJSON = json_decode(file_get_contents($diretorioTabela . $tabela . ".JSON"), true);
			array_push($querys, array(
				$tabela=>$tabelaJSON["QUERY"]
			));
		}
		
		return $querys;
	}


	public function retornarMenu($modulo = string, $rotina = string):string {
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
