<?php

session_start();

require_once "config.php";
require_once "vendor/autoload.php";

use \Kanoah\Model\Modulo;
use \Kanoah\Model\User;
use \Kanoah\BD\SQLServer;
use \Kanoah\Page;
use \Slim\Slim;

$app = new Slim();
$app->config("debug", true);

require_once "_swal.php";

$app->get("/robo", function() {
	// DATA DAS EXECUÇÕES
	// http://10.171.78.41:8006/rest/filtrosportal/BRA/execDay/12.1.025/RPO_D-1/Todas

	// LOG DO FINANCEIRO
	$ch = curl_init("http://10.171.78.41:8006/rest/acompanhamentoExecucaoD1/Detail/FINANCEIRO/BRA/12.1.025/20190926/RPO_D-1/Todas");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: 0'
	));
	
	$resposta = curl_exec($ch);
	curl_close($ch);

	$robo = json_decode($resposta);

	$quebras = array();

	// for ($i = 0; $i < count($robo); $i++)
	// {
	// 	// foreach ($robo[$i] as $chave => $value)
	// 	// {
	// 		var_dump($robo[$i]["erro"]);
	// 		exit;
	// 	// }
	// }

	// echo json_encode($robo);
	// echo json_encode($resposta);

	echo var_dump($robo[1]);
	// var_dump($resposta);

});

$app->post("/api/banco", function() {
	$_SESSION["SERVER"]   = $_REQUEST["SERVER"];
	$_SESSION["DATABASE"] = $_REQUEST["DATABASE"];
	$_SESSION["USER"]     = $_REQUEST["USER"];
	$_SESSION["PASSWORD"] = $_REQUEST["PASSWORD"];

	$conf = array();

	array_push($conf, $_REQUEST["SERVER"]);
	array_push($conf, $_REQUEST["DATABASE"]);
	array_push($conf, $_REQUEST["USER"]);
	array_push($conf, $_REQUEST["PASSWORD"]);

	echo json_encode($conf);
});

if (
	!isset($_SESSION["SERVER"])   || empty($_SESSION["SERVER"])   ||
	!isset($_SESSION["DATABASE"]) || empty($_SESSION["DATABASE"]) ||
	!isset($_SESSION["USER"])     || empty($_SESSION["USER"])     ||
	!isset($_SESSION["PASSWORD"]) || empty($_SESSION["PASSWORD"])
	)
{
	$app->get("/", function ()
	{
		$page = new Page();
		$page->setTpl("banco", array(
			"error" => User::getError()
		));
	});
}
else
{
	$app->get("/", function ()
	{
		$page = new Page();
		$page->setTpl("index", array(
			"error" => User::getError(),
		));
	});

	require_once "functions.php";
	require_once "_kanoah.php";
	require_once "_modulo.php";
	require_once "_rotina.php";
	require_once "_tabela.php";
	require_once "_banco.php";

	require_once "_kanoah_v2.php";
}

$app->post("/banco", function() {
	$_SESSION["SERVER"]   = $_POST["SERVER"];
	$_SESSION["DATABASE"] = $_POST["DATABASE"];
	$_SESSION["USER"]     = $_POST["USER"];
	$_SESSION["PASSWORD"] = $_POST["PASSWORD"];

	header("Location: /");
	exit;
});

$app->notFound(function () use ($app)
{
	if (empty($_SESSION["SERVER"]) || !isset($_SESSION["SERVER"])) {
		User::clearError();
		User::setError("database_undefined");	
	}
	
	User::setError("page_undefined");
});

$app->run();