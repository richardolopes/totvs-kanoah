<?php 

use \Kanoah\Page;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\User;

$app->get("/rotinas", function() {
	$modulos = Rotina::retornarRotinas();
	
	$infModulos = array();
	
	foreach ($modulos as $modulo) {
		$numRotinas    = Rotina::infModulo($modulo, "ROTINAS");
		$numParametros = Rotina::infModulo($modulo, "PARAMETROS");

		array_push($infModulos, array(
			"MODULO"=>$modulo,
			"ROTINAS"=>count($numRotinas),
			"PARAMETROS"=>count($numParametros)
		));
	}
	
	$page = new Page();
	$page->setTpl("rotinas", array(
		"modulos"=>$infModulos
	));
});

?>