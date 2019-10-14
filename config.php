<?php 

use \Kanoah\BD\MySQL;

global $sx3;

$mysql  = new MySQL();
$tabela = "SE1";

$GLOBALS["sx3"] = array();

$return = $mysql->select("SELECT * FROM SX3 WHERE tabela = :TABELA", array(
	":TABELA" => $tabela
));

for ($i = 0; $i < count($return); $i++) {
	$GLOBALS["sx3"][trim($return[$i]["campo"])] = utf8_encode($return[$i]["titulo"]);
}

define("MODULOS","_modulos");
define("TABELAS","_tabelas");
define("ROTINAS","_rotinas");