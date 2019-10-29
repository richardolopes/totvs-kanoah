<?php

use \Kanoah\BD\SQLCongelada;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\Page;

$app->get("/congelada/parametros", function() {
	$sql = new SQLCongelada();

	$result = $sql->select("SELECT BD1.X6_VAR AS PARAMETROBD1, BD1.X6_CONTEUD AS VALORBD1, BD2.X6_CONTEUD AS VALORBD2, BD2.X6_VAR AS PARAMETROBD2, RTRIM(BD1.X6_DESCRIC) + RTRIM(BD1.X6_DESC1) + RTRIM(BD1.X6_DESC2) AS DESCRICAO FROM BASE.dbo.SX6T10 AS BD1 RIGHT JOIN P12125MNTDB.dbo.SX6T10 AS BD2 ON BD2.X6_VAR = BD1.X6_VAR AND BD2.X6_FIL = BD1.X6_FIL WHERE BD2.X6_CONTEUD <> BD1.X6_CONTEUD
	");

	$parametros = array();

	while (odbc_fetch_row($result)) {
		$parametro = trim(odbc_result($result, "PARAMETROBD2"));
		$valor     = trim(odbc_result($result, "VALORBD2"));
		$descricao = trim(utf8_encode(odbc_result($result, "DESCRICAO")));

		$parametros[$parametro] = array(
			$valor => $descricao
		);
	}

	$page = new Page();
	$page->setTpl("congelada-parametros", array(
		"parametros" => $parametros
	));
});


$app->get("/congelada/banco", function() {
	$server   = SQLCongelada::DNS;
	$database = SQLCongelada::DBNAME;
	$user     = SQLCongelada::USERNAME;
	$password = SQLCongelada::PASSWORD;

	$page = new Page();
	$page->setTpl("congelada-banco", array(
		"server"   => $server, 
		"database" => $database, 
		"user"     => $user, 
		"password" => $password 
	));
});
