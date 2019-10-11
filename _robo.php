<?php

use \Kanoah\Model\Rotina;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
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