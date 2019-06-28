<?php 

use \Kanoah\Page;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\BD\SQLServer;

$app->get("/", function() {
	header("Location: /admin");
	exit;
});