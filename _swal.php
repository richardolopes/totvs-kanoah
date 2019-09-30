<?php

use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\Page;

// Fonte criado para testes com o swal.

// Adiciona rotinas no modulo
$app->get("/swal/add/rotina/modulo", function() {
	$modulo = new Modulo();
	$modulo->modulo("SIGAFIN");
	echo Modulo::adicionarRotina($modulo->getid(), "FINA330");
});

// Adiciona rotinas
$app->get("/swal/add/rotina", function() {
	$rotina = "FINR190";
	echo Rotina::criarRotina($rotina);
});