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
	if (isset($_SESSION["precondicao"])) {
		unset($_SESSION["precondicao"]);
	}

	if (isset($_SESSION["rotina"])) {
		unset($_SESSION["rotina"]);
	}

	if (isset($_SESSION["modulo"])) {
		unset($_SESSION["modulo"]);
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

	$_SESSION["modulo"] = $_POST["modulo"];
	$_SESSION["rotina"] = $_POST["rotina"];

	$rotina = new Rotina();
	$rotina->rotina($_SESSION["rotina"]);

	$modulo = new Modulo();
	$modulo->modulo($_SESSION["modulo"]);

	if (!isset($_SESSION["precondicao"]) || empty($_SESSION["precondicao"])) {

		$texto  = "Grupo de empresa: " . $_POST["grupo"] . "\n";
		$texto .= "Filial: " . $_POST["filial"] . "\n";
		$texto .= "Data base: " . (empty($_POST["database"]) ? date("Y-m-d") : $_POST["database"]) . "\n";
		$texto .= "Rotina: " . $rotina->menuRotina($modulo->getmodulo()) . "\n\n\n";

		unset($_POST["modulo"]);
		unset($_POST["rotina"]);
		unset($_POST["grupo"]);
		unset($_POST["filial"]);
		unset($_POST["database"]);

		$parametros = Kanoah::compararParametros($rotina->getrotina());

		if (isset($parametros) && !empty($parametros)) {
			$texto .= "Parâmetros alterados: \n";

			foreach($parametros as $parametro => $conteudo) {
				$texto .= str_pad($parametro, 10) . " = '$conteudo' \n";
			}
			$texto .= "\n\n";
		}

		$tabelas = Tabela::listTabelasRotina($_SESSION["rotina"]);

		while (current($tabelas["precondicao"])) {
			$texto .= utf8_decode(Tabela::infTabelas($_POST[key($tabelas["precondicao"])."QUERY"] . " WHERE " . $_POST[key($tabelas["precondicao"])."WHERE"]));

			next($tabelas["precondicao"]);
		}

		$_SESSION["precondicao"] = $texto;
	}

	$tabelas       = new Tabela();
	$tabelasRotina = $tabelas->tabelasRotina($rotina->getrotina(), 1);

    $page = new Page();
    $page->setTpl("kanoah-res", array(
        "modulo"  => $modulo->getmodulo(),
        "rotina"  => $rotina->getrotina(),
        "tabelas" => $tabelasRotina,
    ));
});

$app->post("/kanoah/rotina/gerar", function () {
	$tabelas = Tabela::listTabelasRotina($_SESSION["rotina"]);

	$resultado = "";

	while (current($tabelas["resultado"])) {
		$resultado .= utf8_decode(Tabela::infTabelas($_POST[key($tabelas["resultado"])."QUERY"] . " WHERE " . $_POST[key($tabelas["resultado"])."WHERE"]));

		next($tabelas["resultado"]);
	}

	$precondicao = $_SESSION["precondicao"];
	unset($_SESSION["precondicao"]);

    $page = new Page();
    $page->setTpl("kanoah-gerar", array(
        "precondicao"=>$precondicao,
        "resultado"=>$resultado
    ));
});
