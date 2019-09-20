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

$app->get("/teste2", function() {
	echo "voltou";
});

$app->get("/teste3", function() {
	$ch = curl_init("http://localhost:12001/teste2");
	curl_setopt_array($ch, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_HEADER         => array("Content-Type:multipart/form-data"), // cURL headers for file uploading
		// CURLOPT_SSL_VERIFYHOST => 0,
		// CURLOPT_SSL_VERIFYPEER => false,
		// CURLOPT_TIMEOUT        => 120, 
		// CURLOPT_URL => 'https://someurl.com/',
		// CURLOPT_POST => 1,
		// CURLOPT_POSTFIELDS => array(
		// 			'user' => "richard.lopes@totvs.com.br",
		// 			'password' => "aa"
		// )
	));
	
	$resposta = curl_exec($ch);
	curl_close($ch);

	echo $resposta;
});



$app->get("/teste", function () {
	$inf = json_encode(array(
		"Username"=>"richard.lopes@totvs.com.br",
		"Password"=>"aaa"
	));

	// echo ($inf);
	// exit;
	try {

		$ch = curl_init("https://apisalas.totvs.com:8888/api/v1/auth/token");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $inf);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		// 'Content-Length: ' . strlen($inf)
	));
	// curl_setopt_array($ch, array(
		// 	CURLOPT_RETURNTRANSFER => 1,
	// 	CURLOPT_HTTPHEADER     => array(
		// 		"Content-Type: application/json",
	// 		"charset=utf-8"
	// 	),
	// 	// CURLOPT_SSL_VERIFYHOST => 0,
	// 	// CURLOPT_SSL_VERIFYPEER => false,
	// 	// CURLOPT_TIMEOUT        => 120, 
	// 	// CURLOPT_URL => 'https://someurl.com/',
	// 	CURLOPT_POST => 1,
	// 	CURLOPT_POSTFIELDS => array(
	// 				'user' => "richard.lopes@totvs.com.br",
	// 				'password' => "aa"
	// 	)
	// ));
	
		$resposta = curl_exec($ch);
		curl_close($ch);
		
		echo $resposta;
	} catch(Excepetion $e) {
		echo $e->getMessage();
	}

	exit;
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