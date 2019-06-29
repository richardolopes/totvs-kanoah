<?php 

use \Kanoah\Page;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\User;

// Retorno em JSON das rotinas do módulo
$app->get("/modulos/rotinas/:modulo", function($modulo) {
	if (isset($modulo)) {
		$rotinas = json_encode(Modulo::infModulo($modulo, "ROTINAS"));

		echo $rotinas;
	} else {
		die("Error: JSONMODULO");
	}
});

$app->get("/modulos", function() {
	$modulos = Modulo::retornarModulos();
	
	$infModulos = array();
	
	foreach ($modulos as $modulo) {
		$numRotinas    = Modulo::infModulo($modulo, "ROTINAS");
		$numParametros = Modulo::infModulo($modulo, "PARAMETROS");

		array_push($infModulos, array(
			"MODULO"=>$modulo,
			"ROTINAS"=>count($numRotinas),
			"PARAMETROS"=>count($numParametros)
		));
	}
	
	$page = new Page();
	$page->setTpl("modulos", array(
		"modulos"=>$infModulos
	));
});


$app->get("/modulos/:modulo", function($modulo) {
	$rotinas    = Modulo::infModulo($modulo, "ROTINAS");
	$parametros = Modulo::infModulo($modulo, "PARAMETROS");

	$page = new Page();
	$page->setTpl("modulo-view", array(
		"modulo"=>$modulo,
		"rotinas"=>$rotinas,
		"parametros"=>$parametros
	));
});


$app->get("/modulos/:modulo/delete/rotina/:rotina", function($nomeModulo, $rotina) {
	$modulo = new Modulo();
	$diretorio = MODULOS . DIRECTORY_SEPARATOR . $nomeModulo . ".JSON";
	$modulo->delete("ROTINAS", $rotina, $diretorio);

	header("Location: /modulos/$nomeModulo");
	exit;
});

$app->get("/modulos/:modulo/delete/parametro/:parametro", function($nomeModulo, $parametro) {
	$modulo = new Modulo();
	$diretorio = MODULOS . DIRECTORY_SEPARATOR . $nomeModulo . ".JSON";
	$modulo->delete("PARAMETROS", $parametro, $diretorio);

	header("Location: /modulos/$nomeModulo");
	exit;
});


?>