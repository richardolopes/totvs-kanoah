<?php

session_start();

require_once "config.php";
require_once "vendor/autoload.php";

use \Slim\Slim;
use \Kanoah\Page;
use \Kanoah\Model\User;

$app = new Slim();
$app->config("debug", true);

$app->get("/", function() {
	$page = new Page();
	$page->setTpl("index", array(
		"error"=>User::getError(),
	));
});

$app->notFound(function () use ($app) {
    User::setError("page_undefined");
	header("Location: /");
	exit;
});

require_once "functions.php";
require_once "kanoah.php";
require_once "modulo.php";
require_once "rotina.php";

$app->run();

?>