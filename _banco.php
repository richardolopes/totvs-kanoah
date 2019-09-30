<?php

use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\Page;

$app->get("/banco/inf", function ()
{
	$page = new Page();
	$page->setTpl("banco-inf", array(
		"server"   => $_SESSION["SERVER"],
		"database" => $_SESSION["DATABASE"],
		"user"     => $_SESSION["USER"],
		"password" => $_SESSION["PASSWORD"]
	));
});

$app->get("/banco/reset", function()
{
	unset($_SESSION["SERVER"]);
	unset($_SESSION["DATABASE"]);
	unset($_SESSION["USER"]);
	unset($_SESSION["PASSWORD"]);

	header("Location: /");
	exit;
});
