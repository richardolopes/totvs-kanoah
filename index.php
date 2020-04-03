<?php

session_start();

require_once "vendor/autoload.php";
require_once "config.php";
require_once "mail.php";

use \Kanoah\BD\SQLBase;
use \Kanoah\BD\SQLServer;
use \Kanoah\Model\Tabela;
use \Kanoah\Model\User;
use \Kanoah\Page;
use \Slim\Slim;

$app = new Slim();
$app->config("debug", true);

$app->get("/teste", function () {
    $rotina = "FINA460";

    $query = "SELECT E5_NUMERO FROM SE5T10 WHERE R_E_C_N_O_ = 1968";

    $tabelas = Tabela::listTabelasRotina($rotina);
    $tabr = $tabelas["resultado"];

    while (current($tabr)) {
        $tabela = key($tabr);
        $relacionamentos = Tabela::relacaoTabela($tabela);

        for ($i = 0; $i < count($relacionamentos); $i++) {
            unset($tabr[$relacionamentos[$i]["tabela"]]);
        }

        next($tabr);
    }

    echo json_encode($tabelas["resultado"]);
    // echo json_encode($tabr);

    exit;

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

$app->get("/menu", function () {
    $menu = array();
    $sql = new SQLBase();

    $rotina = "FINA070";
    $modulo = "SIGAFIN";

    $modquery = $sql->select("
		SELECT M_ID FROM MPMENU_MENU WHERE M_NAME = '$modulo'
	");

    $idmod = odbc_result($modquery, "M_ID");

    $rotquery = $sql->select("
		SELECT F_ID FROM MPMENU_FUNCTION WHERE F_FUNCTION = '$rotina'
	");

    $idrot = odbc_result($rotquery, "F_ID");

    $item = $sql->select("
		SELECT I_ID, I_FATHER FROM MPMENU_ITEM WHERE I_ID_MENU = '$idmod' AND I_ID_FUNC = '$idrot'
	");

    $id1 = odbc_result($item, "I_ID"); // MENU - Ex: Contas a receber
    $id2 = odbc_result($item, "I_ID"); // ROTINA - Ex: Baixas a Receber

    $aux = true;

    while ($aux) {
        $return = $sql->select("

		");

        $return = $sql->select("
			SELECT * FROM MPMENU_ITEM WHERE I_ID = '$id1'
		");

        if (count($return) < 0) {
            $aux = false;
        }
    }

});

if (
    !isset($_SESSION["SERVER"]) || empty($_SESSION["SERVER"]) ||
    !isset($_SESSION["DATABASE"]) || empty($_SESSION["DATABASE"]) ||
    !isset($_SESSION["USER"]) || empty($_SESSION["USER"]) ||
    !isset($_SESSION["PASSWORD"]) || empty($_SESSION["PASSWORD"])
) {
    $app->get("/", function () {
        $page = new Page();
        $page->setTpl("banco", array(
            "error" => User::getError(),
        ));
    });
} else {
    $app->get("/", function () {
        $nome = "Gerador de Kanoah";

        $page = new Page();
        $page->setTpl("index", array(
            "error" => User::getError(),
            "nome" => $nome,
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
    // require_once "_advpr.php";
    require_once "_advpr2.php";

    require_once "_kanoah_v2.php";
}

$app->post("/banco", function () {
    $_SESSION["SERVER"] = $_POST["SERVER"];
    $_SESSION["DATABASE"] = $_POST["DATABASE"];
    $_SESSION["USER"] = $_POST["USER"];
    $_SESSION["PASSWORD"] = $_POST["PASSWORD"];

    try {
        $sql = new SQLServer();
    } catch (Exception $e) {
        unset($_SESSION["SERVER"]);
        unset($_SESSION["DATABASE"]);
        unset($_SESSION["USER"]);
        unset($_SESSION["PASSWORD"]);

        User::setError("sem_conexao");
    }

    header("Location: /");
    exit;
});

$app->get("/attSX3", function () {
    $_SESSION["sx3"] = array();
    User::attSx3();
});

$app->get("/richard", function () {
    $sql = new SQLBase();
    $return = $sql->select("SELECT
					X3_ARQUIVO as tabela,
					X3_CAMPO as campo,
					X3_TITULO as titulo,
					X3_FOLDER as pasta,
					X3_ORDEM as ordem
					FROM SX3T10 WHERE X3_ARQUIVO = 'FVV' ORDER BY X3_ORDEM");

    while (odbc_fetch_row($return)) {
        $tabela = odbc_result($return, "tabela");
        $campo = odbc_result($return, "campo");
        $titulo = odbc_result($return, "titulo");
        $pasta = odbc_result($return, "pasta");
        $ordem = odbc_result($return, "ordem");

        echo utf8_encode($titulo);
        echo "<BR><BR>";
    }

});

$app->notFound(function () use ($app) {
    if (empty($_SESSION["SERVER"]) || !isset($_SESSION["SERVER"])) {
        User::clearError();
        User::setError("database_undefined");
    }

    User::setError("page_undefined");
});

$app->run();
