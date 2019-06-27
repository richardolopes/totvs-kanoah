<?php 

use \Kanoah\PageAdmin;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\BD\SQLServer;

$app->get("/admin", function() {
	$page = new PageAdmin();

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

$app->get("/admin/kanoah/:modulo/:rotina", function($nomeModulo, $nomeRotina) {
	$page = new PageAdmin();

	$modulo = new Modulo();
	$rotina = new Rotina();

	$rotina->infRotina($nomeRotina);

	$parametros = $modulo->retornarParametros($nomeModulo);
	$precondicoes = $rotina->retornarQuerys($rotina->getrotina(), "PRECONDICOES");
	$resultado = $rotina->retornarQuerys($rotina->getrotina(), "RESULTADO");

	$page->setTpl("rotina", array(
		"rotina"=>$nomeRotina,
		"modulo"=>$nomeModulo,
		"parametros"=>$parametros,
		"precondicoes"=>$precondicoes,
		"resultado"=>$resultado,
	));
});


$app->post("/admin/gerarkanoah", function() {
	$page = new PageAdmin();


	$page->setTpl("kanoah");
});

?>