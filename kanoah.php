<?php 

use \Kanoah\Page;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;

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
		$rotinas = json_encode(Rotina::retornarRotinas($modulo));

		echo $rotinas;
	} else {
		die("Error: JSONMODULO");
	}
});

$app->get("/:modulo/:rotina", function($modulo, $rotina) {
	if (isset($modulo, $rotina)) {
		// $page = new Page();

		$tabelasDep = Rotina::retornarDependencias($modulo, $rotina);
		$opcoesDep = Rotina::dependencia($tabelasDep);

		$tabelas = Tabela::retornarQuerys("SA1");
		// echo json_encode($opcoesDep);
		// exit;
		$page->setTpl("rotina", array(
			"modulo"=>$modulo,
			"rotina"=>$rotina,
			"dependencias"=>$opcoesDep
		));
	} else {
		die("Error: ROTINAMODULO");
	}
});
