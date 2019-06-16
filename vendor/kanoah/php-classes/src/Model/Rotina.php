<?php

namespace Kanoah\Model;

// use \Kanoah\BD\Sql;
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

}
