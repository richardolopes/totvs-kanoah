<?php

session_start();

require_once "vendor/autoload.php";
require_once "config.php";

use \Kanoah\Model\Modulo;
use \Kanoah\Model\User;
use \Kanoah\Model\Tabela;
use \Kanoah\BD\SQLServer;
use \Kanoah\BD\MySQL;
use \Kanoah\Page;
use \Slim\Slim;

$app = new Slim();
$app->config("debug", true);

require_once "_robo.php";

if (
	!isset($_SESSION["SERVER"])   || empty($_SESSION["SERVER"])   ||
	!isset($_SESSION["DATABASE"]) || empty($_SESSION["DATABASE"]) ||
	!isset($_SESSION["USER"])     || empty($_SESSION["USER"])     ||
	!isset($_SESSION["PASSWORD"]) || empty($_SESSION["PASSWORD"])
	) {
	$app->get("/", function () {
		$page = new Page();
		$page->setTpl("banco", array(
			"error" => User::getError()
		));
	});
} else {
	$app->get("/", function () {
		$nome = "Gerador de Kanoah";

		$page = new Page();
		$page->setTpl("index", array(
			"error" => User::getError(),
			"nome" => $nome
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

	try {
		$sql = new SQLServer();
	} catch (Exception $e) {
		unset($_SESSION["SERVER"]  );
		unset($_SESSION["DATABASE"]);
		unset($_SESSION["USER"]    );
		unset($_SESSION["PASSWORD"]);

		User::setError("sem_conexao");
	}

	header("Location: /");
	exit;
});

$app->notFound(function () use ($app) {
	if (empty($_SESSION["SERVER"]) || !isset($_SESSION["SERVER"])) {
		User::clearError();
		User::setError("database_undefined");	
	}
	
	User::setError("page_undefined");
});

$app->run();