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
		$rotinas = json_encode(Rotina::retornarRotinas($modulo));

		echo $rotinas;
	} else {
		die("Error: JSONMODULO");
	}
});

$app->get("/:modulo/:rotina", function($nomeModulo, $nomeRotina) {
	$page   = new Page();
	$rotina = new Rotina();
	$tabela = new Tabela();
	
	$rotina->infRotina($nomeModulo, $nomeRotina);
	
	$tabelas = $tabela->infTabelas($rotina->gettabelas());

	$page->setTpl("rotina", array(
		"modulo"=>$nomeModulo,
		"rotina"=>$rotina->getrotina(),
		"tabelas"=>$tabelas
	));
});
