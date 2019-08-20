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

});

$app->get("/rotina/:rotina/add/tabela/pre", function($nomeRotina) {

});

$app->get("/rotina/:rotina/add/tabela/res", function($nomeRotina) {

});