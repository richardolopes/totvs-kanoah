<?php

session_start();

require_once "vendor/autoload.php";
require_once "config.php";

use \Kanoah\Model\User;
use \Kanoah\Model\Modulo;
use \Kanoah\Model\Tabela;
use \Kanoah\Model\Kanoah;
use \Kanoah\BD\SQLServer;
use \Kanoah\BD\SQLBase;
use \Kanoah\BD\MySQL;
use \Kanoah\Page;
use \Slim\Slim;

$app = new Slim();
$app->config("debug", true);

$app->get("/teste", function() {
	$rotina = "FINA460";

	$query = "SELECT E5_NUMERO FROM SE5T10 WHERE R_E_C_N_O_ = 1968";

	$tabelas = Tabela::listTabelasRotina($rotina);

	$relacionamentos = Tabela::relacaoTabela("SE5");
	// echo json_encode($tabelas["precondicao"]);
	// echo json_encode($relacionamentos);

	// exit;
	for ($i = 0; $i < count($relacionamentos); $i++) {
		for ($aux = 0; $aux < count($tabelas); $aux++) {
			foreach ($tabelas["precondicao"][$aux] as $chave => $valor) {
				if ($chave == $relacionamentos[$i]["tabela"]) {
					echo "Tem relacionamento! <br>";
					echo $chave;
					echo "<br><br><br>";
				}
				
			}
		}
	}
});

$app->get("/testee", function() {
	echo Tabela::infTabelas("SELECT E5_TXMOEDA FROM SE5T10 WHERE E5_CLIENTE ='FIN335' AND D_E_L_E_T_ ='' AND E5_TIPODOC <>'RA' ORDER BY R_E_C_N_O_");

});


$app->get("/teste2", function() {
	$menu = array();
	$sql = new SQLBase();

	$rotina = "FINA070";
	$modulo = "SIGAFIN";

	$modquery = $sql->select("
		SELECT * FROM MPMENU_MENU WHERE M_NAME = '$modulo' 
	");

	$idmod = odbc_result($modquery, "M_ID");

	$rotquery = $sql->select("
		SELECT * FROM MPMENU_FUNCTION WHERE F_FUNCTION = '$rotina'
	");

	$idrot = odbc_result($rotquery, "F_ID");

	$item = $sql->select("
		SELECT I_ID, I_FATHER FROM MPMENU_ITEM WHERE I_ID_MENU = '$idmod' AND I_ID_FUNC = '$idrot'
	");

	$iddesc = odbc_result($item, "I_ID");

	$aux = true;
	while ($aux) {

		$return = $sql->select("
			SELECT N_DESC,  FROM MPMENU_I18N WHERE N_PAREN_ID = '$iddesc' AND N_LANG = '1'
		");

		array_push($menu, odbc_result($return, "N_DESC"));
		
		$return = $sql->select("
			SELECT * FROM MPMENU_ITEM WHERE I_ID = '$iddesc'
		");

	}

});

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
	require_once "_rotina.php";
	require_once "_kanoah.php";
	require_once "_modulo.php";
	require_once "_tabela.php";
	require_once "_banco.php";
	require_once "_robo.php";
	require_once "_congelada.php";

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