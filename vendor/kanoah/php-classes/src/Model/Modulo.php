<?php

namespace Kanoah\Model;

// use \Kanoah\BD\Sql;

class Modulo {
	public static function retornarModulos() {
		// Diretório dos módulos
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
}
