<?php

use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\Model\User;
use \Kanoah\BD\MySQL;
use \Kanoah\BD\SQLServer;
use \Kanoah\Page;

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

	$robo = json_decode($resposta, true);

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

	// echo var_dump($robo);
	$_SESSION["ROBO"] = $robo;
	
	var_dump($resposta);

});

$app->get("/robo1", function() {
	$teste = array();
	// echo json_encode($_SESSION["ROBO"][0]);
	for ($i = 0; $i < count($_SESSION["ROBO"]); $i++) {
		// foreach ($_SESSION["ROBO"][$i] as $chave => $value) {
		// 	// echo json_encode($chave);
		// 	// echo "<bR>";
		// 	// echo json_encode($value);
		// 	// // exit;
		// 	// echo "<bR>";
		// 	// echo "<bR>";

		// 	array_push($teste, );

		// }

		array_push($teste, array(
			$_SESSION["ROBO"][$i]["rotina"] => $_SESSION["ROBO"][$i]["erro"]
		));

	}

	echo json_encode($teste);
	echo "<bR>";
	echo "<bR>";
	echo "<bR>";
	// echo json_encode($_SESSION["ROBO"][0]["erro"]);
});

$app->get("/parametros/rotina/:ROTINA" ,function ($nomeRotina) {
	$parametros = shell_exec("py python/parametros.py " . $nomeRotina);
	$remover = array("'", "[", "]", "\n", " ");
	$parametros = str_replace($remover, "", $parametros);
	
	$parametros = explode(",", $parametros);

	$extensao = array(".PRW", ".PRX");
	
	$mysql = new MySQL();
	
	$rotina = new Rotina();
	$rotina->rotina(str_replace($extensao, "", strtoupper($nomeRotina)));

	for ($i = 0; $i < count($parametros); $i++) {
		$idparam = $mysql->select("SELECT id FROM parametro WHERE parametro = :PARAMETRO", array(
			":PARAMETRO" => $parametros[$i]
		));

		if (isset($idparam[0]["id"])) {
			$mysql->query("INSERT INTO `rotina_parametro`(`idrotina`, `idparametro`) VALUES(:IDROT, :IDPARAM)", array(
				":IDROT" => $rotina->getid(),
				":IDPARAM" => $idparam[0]["id"]
			));
		}
	}
});

$app->get("/att/parametros", function() {
	set_time_limit(1800);
	$sql = new SQLServer();
	$mysql = new MySQL();

	$return = $sql->select("SELECT TOP 3 X6_VAR as PARAMETRO, RTRIM (X6_DESCRIC) + RTRIM(X6_DESC1) + RTRIM(X6_DESC2) as DESCRICAO, RTRIM(X6_CONTEUD) as VALOR, X6_TIPO as TIPO, R_E_C_N_O_ as RECNO FROM SX6T10");

	while (odbc_fetch_row($return)) {
		$parametro = odbc_result($return, "PARAMETRO");
		$descricao = odbc_result($return, "DESCRICAO");
		$valor     = odbc_result($return, "VALOR");
		$tipo      = odbc_result($return, "TIPO");
		$recno     = odbc_result($return, "RECNO");

		$mysql->query("INSERT INTO `parametro`(`parametro`, `descricao`, `valor`, `tipo`, `recno`) VALUES(:PARAMETRO, :DESCRICAO, :VALOR, :TIPO, :RECNO)", array(
			":PARAMETRO" => $parametro,
			":DESCRICAO" => $descricao,
			":VALOR" => $valor,
			":TIPO" => $tipo,
			":RECNO" => $recno
		));
	}

	User::setError("PARAMETROS_ATT");
});

$app->get("/att/sx3/:tabela", function($tabela) {
	set_time_limit(900);

	$sql = new SQLServer();
	$mysql = new MySQL();

	$return = $sql->select("SELECT
		X3_ARQUIVO as tabela, 
		X3_CAMPO as campo, 
		X3_TITULO as titulo, 
		X3_FOLDER as pasta, 
		X3_ORDEM as ordem 
	FROM SX3T10 WHERE X3_ARQUIVO = '$tabela' ORDER BY X3_ORDEM");

	while (odbc_fetch_row($return)) {
		$tabela = odbc_result($return, "tabela");
		$campo  = odbc_result($return, "campo");
		$titulo = odbc_result($return, "titulo");
		$pasta  = odbc_result($return, "pasta");
		$ordem  = odbc_result($return, "ordem");

		$mysql->query("INSERT INTO `sx3`(`tabela`, `campo`, `titulo`, `pasta`, `ordem`) VALUES (
			:TABELA, 
			:CAMPO, 
			:TITULO, 
			:PASTA, 
			:ORDEM)", array(
			":TABELA" => $tabela,
			":CAMPO"  => $campo,
			":TITULO" => $titulo,
			":PASTA"  => $pasta,
			":ORDEM"  => $ordem
		));
	}
});
