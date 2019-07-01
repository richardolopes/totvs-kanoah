<?php 

use \Kanoah\Page;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\Model\User;
use \Kanoah\BD\SQLServer;

$app->get("/kanoah", function() {
	$modulos = Modulo::retornarModulos();
	
	$page = new Page();
	$page->setTpl("kanoah", array(
		"error"=>User::getError(),
		"modulos"=>$modulos
	));
});

$app->post("/kanoah", function() {
	$nomeModulo = $_POST["modulo"];
	$nomeRotina = $_POST["rotina"];

	$rotina = new Rotina();
	
	$rotina->infRotina($nomeRotina);
	
	$parametros = Modulo::infModulo($nomeModulo, "ROTINAS");
	$precondicoes = $rotina->retornarQuerys($rotina->getrotina(), "PRECONDICOES");
	$resultado = $rotina->retornarQuerys($rotina->getrotina(), "RESULTADO");
	
	$page = new Page();
	$page->setTpl("kanoah-rotina", array(
		"rotina"=>$nomeRotina,
		"modulo"=>$nomeModulo,
		"parametros"=>$parametros,
		"precondicoes"=>$precondicoes,
		"resultado"=>$resultado,
	));
});

$app->get("/kanoah/query", function() {
	$page = new Page();
	$page->setTpl("kanoah-query");
});

$app->post("/kanoah/query", function() {
	sleep(3);
	if (!empty($_POST["query"])) {
		$txtResultado = utf8_encode(Tabela::infTabelas($_POST["query"]));
	
		echo $txtResultado;
	} else {
		User::setError("query_undefined");
				
		header("Location: /");
		exit;
	}
});

$app->post("/kanoah/gerar", function() {
	$rotina = new Rotina();

	$rotina->infRotina($_POST["rotina"]);

	$precondicoes = $rotina->retornarQuerys($rotina->getrotina(), "PRECONDICOES");
	$resultado    = $rotina->retornarQuerys($rotina->getrotina(), "RESULTADO");

	$txtPrecondicoes  = "Grupo de empresa: " . $_POST["grupo"] . "\n";
	$txtPrecondicoes .= "Filial: " . $_POST["filial"] . "\n";
	$txtPrecondicoes .= "Data base: " . (empty($_POST["database"]) ? date("Y-m-d") : $_POST["database"]) . "\n";
	$txtPrecondicoes .= "Rotina: " . utf8_encode($rotina->retornarMenu($_POST["modulo"], $_POST["rotina"])) . "\n\n";

	$txtResultado = "";

	for ($i = 0; $i < count($precondicoes); $i++) {
		foreach ($precondicoes[$i] as $tabela => $value) {
			if (stristr($_POST["PRE".$tabela."WHERE"], "WHERE")) {
				User::setError("user_where");
				 
				header("Location: /kanoah");
				exit;
			}

			if (empty($_POST["PRE".$tabela."WHERE"])) {
				User::setError("wheres_undefined");
				
				header("Location: /kanoah");
				exit;
			}

			$txtPrecondicoes .= utf8_encode(Tabela::infTabelas($_POST["PRE".$tabela."QUERY"] . " WHERE " . $_POST["PRE".$tabela."WHERE"]));
		}
	}

	for ($i = 0; $i < count($resultado); $i++) {
		foreach ($resultado[$i] as $tabela => $value) {
			if (stristr($_POST["RES".$tabela."WHERE"], "WHERE")) {
				User::setError("user_where");
				 
				header("Location: /kanoah");
				exit;
			}
			
			if (empty($_POST["RES".$tabela."WHERE"])) {
				User::setError("wheres_undefined");
				
				header("Location: /kanoah");
				exit;
			}

			$txtResultado .= utf8_encode(Tabela::infTabelas($_POST["RES".$tabela."QUERY"] . " WHERE " . $_POST["RES".$tabela."WHERE"]));
		}
	}

	$page = new Page();
	$page->setTpl("kanoah-gerar", array(
		"precondicoes"=>$txtPrecondicoes,
		"resultado"=>$txtResultado,
	));
});

?>