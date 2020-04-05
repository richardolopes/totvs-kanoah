<?php

use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\Page;

$app->get("/tabelas", function ()
{
	$tabelas = Tabela::listTabelas();

	$page = new Page();
	$page->setTpl("tabelas", array(
		"tabelas"=>$tabelas
	));
});

$app->get("/tabela/add", function ()
{
	$page = new Page();
	$page->setTpl("tabela-add");
});

$app->post("/tabela/add", function ()
{
	Tabela::criarTabela($_POST["tabela"], $_POST["nome"], $_POST["query"]);
	
	header("Location: /tabelas");
	exit;
});

$app->get("/tabela/:id", function ($nomeTabela)
{
	$tabela = new Tabela();
	$tabela->tabela($nomeTabela);
	$relacao = $tabela->relacaoTabela($nomeTabela);

	$page = new Page();
	$page->setTpl("tabela-view", array(
		"tabela"=>$tabela->gettabela(),
		"nome"=>$tabela->getnome(),
		"query"=>$tabela->getquery(),
		"relacao"=>$relacao
	));
});