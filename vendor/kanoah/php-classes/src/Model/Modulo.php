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
	
			while($modulo = $diretorio->read()) {
				$modulo = explode(".", $modulo); // Retira a extensão .JSON
				array_push($modulos, $modulo[0]);
			}
	
			$diretorio->close();
			
			return $modulos;
		} else {
			return ["??"];
		}
	}

	public static function infModulo($modulo = string, $inf = string):array {
		$diretorio = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . MODULOS . DIRECTORY_SEPARATOR;

		$json = json_decode(file_get_contents($diretorio . $modulo . ".JSON"), true);

		return $json[$inf];
	}

	public function delete($chave, $inf, $arq) {
		$diretorio = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . $arq;

		$array = file_get_contents($diretorio);
		$json = json_decode($array, true);

		$num = array_search($inf, $json[$chave]);
		
		unset($json[$chave][$num]);

		$aux = array($chave => array_values($json[$chave]));

		unset($json[$chave]);
		
		$json = array_merge($json, $aux);

		// echo json_encode($json);

		unlink($diretorio);
		$fp = fopen($diretorio, 'w');
		// escreve no ficheiro em json
		fwrite($fp, json_encode($json));
		// fecha o ficheiro
		fclose($fp);
		// exit;

	}
}
