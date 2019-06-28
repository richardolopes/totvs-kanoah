<?php 

use \Kanoah\PageAdmin;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\Model\User;
use \Kanoah\BD\SQLServer;

$app->get("/admin", function() {
	$page = new PageAdmin();

	$modulos = Modulo::retornarModulos();

	$page->setTpl("index", array(
		"error"=>User::getError(),
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

$app->post("/admin/kanoah", function() {
	$nomeModulo = $_POST["modulo"];
	$nomeRotina = $_POST["rotina"];

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

	$rotina = new Rotina();

	$rotina->infRotina($_POST["rotina"]);

	$precondicoes = $rotina->retornarQuerys($rotina->getrotina(), "PRECONDICOES");
	$resultado = $rotina->retornarQuerys($rotina->getrotina(), "RESULTADO");

	$txtPrecondicoes  = "Grupo de empresa: " . $_POST["grupo"] . "\n";
	$txtPrecondicoes .= "Filial: " . $_POST["filial"] . "\n";
	$txtPrecondicoes .= "Data base: " . (empty($_POST["database"]) ? date("Y-m-d") : $_POST["database"]) . "\n";
	$txtPrecondicoes .= "Rotina: " . utf8_encode($rotina->retornarMenu($_POST["modulo"], $_POST["rotina"])) . "\n\n";

	$txtResultado = "";

	for ($i = 0; $i < count($precondicoes); $i++) {
		foreach ($precondicoes[$i] as $tabela => $value) {
			if (stristr($_POST[$tabela."WHERE"], "WHERE")) {
				User::setError("user_where");
				 
				header("Location: /admin");
				exit;
			}

			if (empty($_POST[$tabela."WHERE"])) {
				User::setError("wheres_undefined");
				
				header("Location: /admin");
				exit;
			}

			$txtPrecondicoes .= utf8_encode(Tabela::infTabelas($_POST[$tabela."QUERY"] . " WHERE " . $_POST[$tabela."WHERE"]));
		}
	}

	for ($i = 0; $i < count($resultado); $i++) {
		foreach ($resultado[$i] as $tabela => $value) {
			if (stristr($_POST[$tabela."WHERE"], "WHERE")) {
				User::setError("user_where");
				 
				header("Location: /admin");
				exit;
			}
			
			if (empty($_POST[$tabela."WHERE"])) {
				User::setError("wheres_undefined");
				
				header("Location: /admin");
				exit;
			}

			$txtResultado .= utf8_encode(Tabela::infTabelas($_POST[$tabela."QUERY"] . " WHERE " . $_POST[$tabela."WHERE"]));
		}
	}

	$page->setTpl("kanoah", array(
		"precondicoes"=>$txtPrecondicoes,
		"resultado"=>$txtResultado,
	));
});

?>