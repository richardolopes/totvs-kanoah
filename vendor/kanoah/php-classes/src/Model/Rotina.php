<?php

namespace Kanoah\Model;

// use \Kanoah\BD\Sql;
use \Kanoah\Model;

class Rotina extends Model {
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

	public static function rotina($modulo, $rotina) {
		// retornar parametros 
	}

	// Retorna as tabelas dependentes.
	public static function retornarDependencias($modulo, $rotina) {
		$array = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . MODULOS . DIRECTORY_SEPARATOR . $modulo . DIRECTORY_SEPARATOR . $rotina . ".JSON"), true);

		if (isset($array["DEPENDENCIAS"])) {
			$dependencias = array();

			foreach ($array["DEPENDENCIAS"] as $key => $value) {
				$tabela = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . TABELAS . DIRECTORY_SEPARATOR . $value . ".JSON"), true);

				// array_push($dependencias, $tabela["TABELA"]);
			}
			echo json_encode($tabela);
			exit;
			exit;
			return $dependencias;
		} else {
			die("ERROR JSON0");
		}
	}

	// Retornar os cadastros definidos.
	public static function dependencia($dependencias) {
		$cadastros = array();
		
		foreach ($dependencias as $key) {
			$tabela = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . TABELAS . DIRECTORY_SEPARATOR . $key . ".JSON"), true);
			
			$aux = array();
			
			foreach ($tabela["REGISTROS_DEFINIDOS"] as $key2 => $value) {
				array_push($aux, $key2);
			}

			array_push($cadastros, array(
				$key => $aux
			));
		}

		return $cadastros;
	}
}
