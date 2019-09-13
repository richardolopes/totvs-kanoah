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

$app->get("/sair", function() {
	unset($_SESSION["SERVER"]);
	unset($_SESSION["DATABASE"]);
	unset($_SESSION["USER"]);
	unset($_SESSION["PASSWORD"]);

	header("Location: /");
	exit;
});

$app->get("/conf", function() {
	echo "<textarea cols=60 rows=15>";
	echo "SERVER:   " . $_SESSION["SERVER"];
	echo "\n";
	echo "DATABASE: " . $_SESSION["DATABASE"];
	echo "\n";
	echo "USUARIO:  " . $_SESSION["USER"];
	echo "\n";
	echo "SENHA:    " . $_SESSION["PASSWORD"];
	echo "</textarea>";
	exit;
});

$app->post("/banco", function() {
	$_SESSION["SERVER"]   = $_POST["SERVER"];
	$_SESSION["DATABASE"] = $_POST["DATABASE"];
	$_SESSION["USER"]     = $_POST["USER"];
	$_SESSION["PASSWORD"] = $_POST["PASSWORD"];

	header("Location: /");
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
		// $tempo = time() + 7200;
		// $cookie = "Este valor será armazenado";
		// $nome_cookie = "precondicao";

		// setcookie($nome_cookie, $cookie, $tempo);

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

	$app->get("/teste", function ()
	{
		$sql = new SQLServer();
		var_dump($sql);
	});

	require_once "functions.php";
	require_once "_kanoah.php";
	require_once "_modulo.php";
	require_once "_rotina.php";
	require_once "_tabela.php";

	require_once "_kanoah_v2.php";
}

$app->notFound(function () use ($app)
{
	if (empty($_SESSION["SERVER"]) || !isset($_SESSION["SERVER"])) {
		User::clearError();
		User::setError("database_undefined");	
	}
	
	User::setError("page_undefined");
});

$app->run();