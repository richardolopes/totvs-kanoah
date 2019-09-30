<?php

use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Parametro;
use \Kanoah\Page;

$app->get("/modulos", function ()
{
	$modulos = Modulo::listModulos();

	$page = new Page();
	$page->setTpl("modulos", array(
		"modulos"=>$modulos
	));
});

$app->post("/modulo/criar", function ()
{
	echo Modulo::criarModulo($_POST["modulo"]);
});

$app->get("/modulo/:modulo/rotinas", function ($modulo)
{
    echo json_encode(Rotina::listRotinasModulo($modulo));
});

$app->get("/modulo/:modulo", function ($nomeModulo)
{
	$modulo = new Modulo();
	$modulo->modulo($nomeModulo);

	$rotinas = Rotina::listRotinasModulo($modulo->getmodulo());
	$parametros = Parametro::listParametrosModulo($modulo->getmodulo());

	$page = new Page();
	$page->setTpl("modulo-view", array(
		"modulo"=>$modulo->getmodulo(),
		"rotinas"=>$rotinas,
		"parametros"=>$parametros
	));
});

$app->get("/modulo/:modulo/delete/rotina/:rotina", function($nomeModulo, $nomeRotina) {
	$modulo = new Modulo();
	$modulo->modulo($nomeModulo);

	$rotina = new Rotina();
	$rotina->rotina($nomeRotina);

	$rotina->delRotinaModulo($modulo->getid(), $rotina->getid());

	header("Location: /modulos/$nomeModulo");
	exit;
});

$app->get("/modulo/:modulo/delete/parametro/:parametro", function($nomeModulo, $nomeParametro) {
	$modulo = new Modulo();
	$modulo->modulo($nomeModulo);
	
	$parametro = new Parametro();
	$parametro->parametro($nomeParametro);

	$parametro->delParametroModulo($modulo->getid(), $parametro->getid());

	header("Location: /modulos/$nomeModulo");
	exit;
});

$app->post("/modulo/:modulo/add/rotina", function($nomeModulo) {
	$modulo = new Modulo();
	$modulo->modulo($nomeModulo);
	echo Modulo::adicionarRotina($modulo->getid(), $_POST["rotina"]);
});


$app->get("/modulo/:modulo/add/parametro", function($nomeModulo) {
	$page = new Page();
	$page->setTpl("modulo-add-parametro", array(
		"modulo"=>$nomeModulo
	));
});


