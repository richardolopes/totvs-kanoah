<?php

use \Kanoah\Model\Modulo;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Tabela;
use \Kanoah\Model\Kanoah;
use \Kanoah\Model\User;
use \Kanoah\Model\Parametro;
use \Kanoah\Page;

$app->get("/kanoah", function ()
{
    $modulos = Modulo::modulosComRotina();

    $page = new Page();
    $page->setTpl("kanoah", array(
        "modulos" => $modulos,
    ));
});

$app->get("/kanoah/query", function () 
{
    $page = new Page();
    $page->setTpl("kanoah-query");
});

$app->post("/kanoah/query", function () 
{
	if (!empty($_POST["query"])) {
		$txtResultado = Tabela::infTabelas($_POST["query"]);
	
		echo $txtResultado;
	} else {
		User::setError("EMPTY_QUERY");
	}
});

$app->post("/kanoah/rotina/pre", function ()
{
	if (isset($_COOKIE["precondicao"])) {
		setcookie("precondicao", "", time()-3600);
	}
	
	if (isset($_COOKIE["rotina"])) {
		setcookie("rotina", "", time()-3600);
	}
	
	if (isset($_COOKIE["modulo"])) {
		setcookie("modulo", "", time()-3600);
	}

    if (empty($_POST["modulo"]))
    {
        User::setError("EMPTY_POSTMODULO");
    }

    if (empty($_POST["rotina"]))
    {
        User::setError("EMPTY_POSTROTINA");
    }

    $modulo = new Modulo();
    $modulo->modulo($_POST["modulo"]);

    $rotina = new Rotina();
    $rotina->rotina($_POST["rotina"]);

	$tabelas       = new Tabela();
	$tabelasRotina = $tabelas->tabelasRotina($rotina->getrotina(), 0);

    $page = new Page();
    $page->setTpl("kanoah-pre", array(
        "modulo"  => $modulo->getmodulo(),
        "rotina"  => $rotina->getrotina(),
        "tabelas" => $tabelasRotina,
    ));
});

$app->post("/kanoah/rotina/res", function ()
{
    if (empty($_POST["modulo"])) {
        User::setError("EMPTY_POSTMODULO");
    }

    if (empty($_POST["rotina"])) {
        User::setError("EMPTY_POSTROTINA");
	}
	
	setcookie("modulo", $_POST["modulo"], time()+60*60*24*365);
	setcookie("rotina", $_POST["rotina"], time()+60*60*24*365);

	$rotina = new Rotina();
	$rotina->rotina($_POST["rotina"]);

	$modulo = new Modulo();
	$modulo->modulo($_POST["modulo"]);

	

	

	exit;


	if (!isset($_COOKIE["precondicao"]) || empty($_COOKIE["precondicao"])) {
		$texto  = "Grupo de empresa: " . $_POST["grupo"] . "\n";
		$texto .= "Filial: " . $_POST["filial"] . "\n";
		$texto .= "Data base: " . (empty($_POST["database"]) ? date("Y-m-d") : $_POST["database"]) . "\n";
		$texto .= "Rotina: " . $rotina->menuRotina($modulo->getmodulo()) . "\n\n";
		
		$tabelas = Tabela::listTabelasRotina($_POST["rotina"]);
		
		for ($i = 0; $i < count($tabelas); $i++) {
			foreach ($tabelas["precondicao"][$i] as $key => $value) {
				$texto .= Tabela::infTabelas($_POST[$key."QUERY"] . " WHERE " . $_POST[$key."WHERE"]);
			}
		}
		
		setcookie("precondicao", $texto, time()+60*60*24*365);
	}

    $modulo = new Modulo();
    $modulo->modulo($_POST["modulo"]);
	
    $rotina = new Rotina();
    $rotina->rotina($_POST["rotina"]);
	
	$tabelas       = new Tabela();
	$tabelasRotina = $tabelas->tabelasRotina($rotina->getrotina(), 1);

    $page = new Page();
    $page->setTpl("kanoah-res", array(
        "modulo"  => $modulo->getmodulo(),
        "rotina"  => $rotina->getrotina(),
        "tabelas" => $tabelasRotina,
    ));
});

$app->post("/kanoah/rotina/gerar", function ()
{
	$tabelas = Tabela::listTabelasRotina($_COOKIE["rotina"]);

	$resultado = "";

	for ($i = 0; $i < count($tabelas["resultado"]); $i++) {
		foreach ($tabelas["resultado"][$i] as $key => $value) {
			$resultado .= Tabela::infTabelas($_POST[$key."QUERY"] . " WHERE " . $_POST[$key."WHERE"]);
		}
	}

	$precondicao = $_COOKIE["precondicao"];
	setcookie("precondicao", "", time()-3600);

    $page = new Page();
    $page->setTpl("kanoah-gerar", array(
        "precondicao"=>$precondicao,
        "resultado"=>$resultado
    ));
});
