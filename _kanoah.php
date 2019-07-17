<?php

use \Kanoah\Model\Modulo;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Tabela;
use \Kanoah\Model\Kanoah;
use \Kanoah\Model\User;
use \Kanoah\Page;

$app->get("/kanoah", function ()
{
    $modulos = Modulo::listModulos();

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

$app->post("/kanoah/rotina", function ()
{
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
    $tabelasRotina = $tabelas->listTabelasRotina($rotina->getrotina());

    $page = new Page();
    $page->setTpl("kanoah-rotina", array(
        "modulo"  => $modulo->getmodulo(),
        "rotina"  => $rotina->getrotina(),
        "tabelas" => $tabelasRotina,
    ));
});

$app->post("/kanoah/rotina/gerar", function ()
{
    $modulo = new Modulo();
    $modulo->modulo($_POST["modulo"]);

    $rotina = new Rotina();
    $rotina->rotina($_POST["rotina"]);

    $tabelas       = new Tabela();
    $tabelasRotina = $tabelas->listTabelasRotina($rotina->getrotina());

    $texto  = "Grupo de empresa: " . $_POST["grupo"] . "\n";
    $texto .= "Filial: " . $_POST["filial"] . "\n";
    $texto .= "Data base: " . (empty($_POST["database"]) ? date("Y-m-d") : $_POST["database"]) . "\n";
    $texto .= "Rotina: " . $rotina->menuRotina($modulo->getmodulo()) . "\n\n";

    $kanoah = new Kanoah();
    $texto  = $kanoah->gerarKanoah($tabelasRotina);

    $page = new Page();
    $page->setTpl("kanoah-gerar", array(
        "precondicao"=>$texto["precondicao"][0],
        "resultado"=>$texto["resultado"][0]
    ));
});
