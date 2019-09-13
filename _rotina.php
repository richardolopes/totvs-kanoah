<?php

use \Kanoah\Model\Rotina;
use \Kanoah\Model\Tabela;
use \Kanoah\Model\Parametro;
use \Kanoah\Page;

// $app->get("/rotinas", function ()
// {
//     $modulos = Rotina::retornarRotinas();

//     $infModulos = array();

//     foreach ($modulos as $modulo)
//     {
//         $numRotinas    = Rotina::infModulo($modulo, "ROTINAS");
//         $numParametros = Rotina::infModulo($modulo, "PARAMETROS");

//         array_push($infModulos, array(
//             "MODULO"     => $modulo,
//             "ROTINAS"    => count($numRotinas),
//             "PARAMETROS" => count($numParametros),
//         ));
//     }

//     $page = new Page();
//     $page->setTpl("rotinas", array(
//         "modulos" => $infModulos,
//     ));
// });

$app->get("/rotinas", function ()
{
	$rotinas = Rotina::listRotinas();

	for ($i = 0; $i < count($rotinas); $i++)
	{
		foreach ($rotinas[$i] as $value)
		{
			$rotinas[$i]["parametros"] = count(Parametro::listParametrosRotina($value));

			$tabelas = Tabela::listTabelasRotina($value);

			$rotinas[$i]["tabelas"] = count($tabelas["resultado"]) + count($tabelas["precondicao"]);
		}
	}

    $page = new Page();
    $page->setTpl("rotinas", array(
        "rotinas" => $rotinas,
    ));
});

$app->get("/rotina/add", function() {
	$page = new Page();
	$page->setTpl("rotina-add");
});

$app->get("/rotina/:id", function($nomeRotina) {
	$rotina = new Rotina();
	$rotina->rotina($nomeRotina);

	$tabelas = Tabela::listTabelasRotina($rotina->getrotina());
	$parametros = Parametro::listParametrosRotina($rotina->getrotina());

	$page = new Page();
	$page->setTpl("rotina-view", array(
		"rotina"=>$rotina->getrotina(),
		"nome"=>$rotina->getnome(),
		"precondicao"=>$tabelas["precondicao"],
		"resultado"=>$tabelas["resultado"],
		"parametros"=>$parametros
	));
});

$app->get("/rotina/:rotina/add/parametro", function($nomeRotina) {
	// $modulo = new Modulo();
	// $modulo->modulo($nomeModulo);

	$page = new Page();
	$page->setTpl("rotina-add-parametro", array(
		// "modulo"=>$modulo->getmodulo()
	));
});

$app->get("/rotina/:rotina/add/tabela", function($nomeRotina) {
	$tabs = Tabela::listTabelas();

	$tabelas = array();
	foreach ($tabs as $key => $value) {
		foreach ($value as $chave => $e) {
			array_push($tabelas, $e);
		}
	}

	$tabsRotina = Tabela::listTabelasRotina($nomeRotina);

	// pre condicao - ja add
	$_SESSION["tabelasPrecondicao"] = array();
	$_SESSION["tabelasPrecondicao"] = Tabela::ajustarTabelas($tabsRotina["precondicao"]);
	
	// resultado esperado - ja add
	$_SESSION["tabelasResultado"] = array();
	$_SESSION["tabelasResultado"] = Tabela::ajustarTabelas($tabsRotina["resultado"]);

	// Tabelas que ainda nao foram adicionadas no resultado esperado
	$_SESSION["tabsNaddRes"] = array();
	foreach (array_diff($tabelas, $_SESSION["tabelasResultado"]) as $key => $value) {
		array_push($_SESSION["tabsNaddRes"], $value);
	}

	// Tabelas que ainda nao foram adicionadas na pre condicao
	$_SESSION["tabsNaddPre"] = array();
	foreach (array_diff($tabelas, $_SESSION["tabelasPrecondicao"]) as $key => $value) {
		array_push($_SESSION["tabsNaddPre"], $value);
	}

	$page = new Page();
	$page->setTpl("rotina-add-tabela", array(
		"tipo"     => 0,
		"rotina"   => $nomeRotina,
		"tabsPre"  => $_SESSION["tabelasPrecondicao"],
		"tabsRes"  => $_SESSION["tabelasResultado"],
		"tabsNPre" => $_SESSION["tabsNaddPre"],
		"tabsNRes" => $_SESSION["tabsNaddRes"]
	));
});


$app->post("/rotina/:rotina/add/tabela", function($nomeRotina) {
	
	$rotina = new Rotina();
	$rotina->rotina($nomeRotina);
	
	// Tabelas para adicionar
	$tabsAddPre = array();
	foreach($_SESSION["tabsNaddPre"] as $key => $value) {
		if (isset($_POST["tabsNPre$value"])) {
			array_push($tabsAddPre, $_POST["tabsNPre$value"]);
		}
	}
	
	$tabsAddRes = array();
	foreach($_SESSION["tabsNaddRes"] as $key => $value) {
		if (isset($_POST["tabsNRes$value"])) {
			array_push($tabsAddRes, $_POST["tabsNRes$value"]);
		}
	}

	$tabela = new Tabela();

	if (isset($tabsAddPre)) {
		$tabela->addTabRot($rotina->getid(), $tabsAddPre, "0");
	}

	if (isset($tabsAddRes)) {
		$tabela->addTabRot($rotina->getid(), $tabsAddRes, 1);
	}

	header("Location: /rotina/" . $rotina->getrotina());
	exit;
});

$app->get("/rotina/:rotina/delete/tabela/pre/:tabela", function($nomeRotina, $nomeTabela) {
	$rotina = new Rotina();
	$rotina->rotina($nomeRotina);

	$tabela = new Tabela();
	$tabela->tabela($nomeTabela);

	$rotina->delTabelaRotina($rotina->getid(), $tabela->getid(), 0);

	header("Location: /rotina/". $rotina->getrotina());
	exit;
});

$app->get("/rotina/:rotina/delete/tabela/res/:tabela", function($nomeRotina, $nomeTabela) {
	$rotina = new Rotina();
	$rotina->rotina($nomeRotina);

	$tabela = new Tabela();
	$tabela->tabela($nomeTabela);

	$rotina->delTabelaRotina($rotina->getid(), $tabela->getid(), 1);

	header("Location: /rotina/". $rotina->getrotina());
	exit;
});