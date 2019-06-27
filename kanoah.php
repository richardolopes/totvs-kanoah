<?php 

use \Kanoah\Page;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\BD\SQLServer;

$app->get("/", function() {
	$page = new Page();

	$modulos = Modulo::retornarModulos();

	$page->setTpl("index", array(
		"modulos"=>$modulos
	));
});

// Retorno em JSON das rotinas do módulo
$app->get("/rotinas/:modulo", function($modulo) {
	if (isset($modulo)) {
		$rotinas = json_encode(Modulo::retornarRotinas($modulo));

		echo $rotinas;
	} else {
		die("Error: JSONMODULO");
	}
});

$app->get("/tabela/:tabela", function($tabela) {
	$infTabela = new Tabela();
	$tabelas = $infTabela->infTabelas(array(
		$tabela
	));

	echo json_encode($tabelas);
});

$app->get("/query/:tabela", function($tabela) {
	$infTabela = new Tabela();
	$tabelas = $infTabela->infTabelas(array(
		$tabela
	));

	echo json_encode([$tabelas[0]["QUERY"]]);
});


$app->get("/inf/:modulo/:rotina", function($nomeModulo, $nomeRotina) {
	$page   = new Page();
	$rotina = new Rotina();
	$tabela = new Tabela();
	
	$rotina->infRotina($nomeModulo, $nomeRotina);
	
	$tabelas = $tabela->infTabelas($rotina->gettabelas());
	
	$dependencias = $rotina->infTabelasDep($rotina->getdependencias());
	
	$page->setTpl("rotina", array(
		"modulo"=>$nomeModulo,
		"rotina"=>$rotina->getrotina(),
		"tabelas"=>$tabelas,
		"dependencias"=>$dependencias
	));
});

$app->get("/gerarkanoah", function() {
	$page = new Page();

	if (isset($_GET["modulo"]) && isset($_GET["rotina"])) {
		$rotina  = new Rotina();
		$rotina->infRotina($_GET["modulo"], $_GET["rotina"]);

		$kanoah  = "Acesse o módulo " . $_GET["modulo"] . " > ";
		$kanoah .= utf8_encode(Rotina::retornarMenu($_GET["modulo"], $_GET["rotina"])) . "\n\n";

		// Retorna as dependencias da rotina
		$dependenciasRotina = $rotina->getdependencias();

		// Verifica se as dependencias foram definidas.
		foreach ($dependenciasRotina as $key) if (!isset($_GET[$key])) die("Alguma dependencia não foi definida.");

		$tabela = new Tabela();
		$dependencias = $tabela->infTabelas($rotina->getdependencias());

		$sql = new SQLServer();

		// foreach ($dependenciasRotina as $key) {
		// 	if ($_GET[$key] != "query") {
				
		// 	} else {
		// 		echo "teste<br>";
		// 		$return = $sql->select("SELECT * FROM SE1T10 WHERE E1_PREFIXO = 'RIC' ");

		// 		while (odbc_fetch_row($return)) {
		// 			$kanoah += odbc_result($return);
		// 		}
		// 	}
		// }

		$return = $sql->select($_GET["resultado"]);

		while (odbc_fetch_row($return) ) {
			for ($j = 1; $j <= odbc_num_fields($return); $j++) {        
				$field_name = odbc_field_name($return, $j);
				$kanoah .= str_pad($field_name, 10) . " = '" . odbc_result($return, $field_name) . "'\n";
			}
			$kanoah .= "\n\n";
		}

		// echo "" $kanoah;
		// exit;

	} else {
		die("Módulo ou rotina não foi definido.");
	}

	$page->setTpl("kanoah", array(
		"kanoah"=>$kanoah
	));
});