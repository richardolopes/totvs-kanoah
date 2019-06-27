<?php

namespace Kanoah\Model;

class Modulo {
	public static function retornarModulos() {
		// Diretório dos módulos.
		$path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . MODULOS . DIRECTORY_SEPARATOR;
		$diretorio = @dir($path);
	
		$modulos = array();
	
		if (!empty($diretorio)) {
			// Pulas os diretórios '.' e '..'
			$diretorio->read();
			$diretorio->read();
	
			while($modulo = $diretorio->read()){
				$modulo = explode(".", $modulo); // Retira a extensão .JSON
				array_push($modulos, $modulo[0]);
			}
	
			$diretorio->close();
			
			return $modulos;
		} else {
			return ["??"];
		}
	}

	// Retorna um array com as rotinas do módulo.
	public static function retornarRotinas($modulo = string):array {
		$diretorio = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . MODULOS . DIRECTORY_SEPARATOR;

		$json = json_decode(file_get_contents($diretorio . $modulo . ".JSON"), true);

		return $json["ROTINAS"];
	}

	public function retornarParametros($modulo = string):array {
		$diretorio = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . MODULOS . DIRECTORY_SEPARATOR;

		$json = json_decode(file_get_contents($diretorio . $modulo . ".JSON"), true);

		return $json["PARAMETROS"];
	}
}
