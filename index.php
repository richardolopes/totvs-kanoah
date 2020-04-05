<?php

session_start();

require_once "vendor/autoload.php";
require_once "routes/_config.php";

use \Kanoah\BD\SQLServer;
use \Kanoah\Model\User;
use \Kanoah\Page;
use \Slim\Slim;

$app = new Slim();
$app->config("debug", true);

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

    // Funções auxiliares
    require_once "routes/__testes.php";
    require_once "routes/_functions.php";

    // Kanoahndo
    require_once "routes/_rotina.php";
    require_once "routes/_kanoah.php";
    require_once "routes/_modulo.php";
    require_once "routes/_tabela.php";
    require_once "routes/_banco.php";
    require_once "routes/_robo.php";
    require_once "routes/_congelada.php";

    require_once "routes/v2/index.php";

    // Robô de automação
    require_once "mail.php";
    require_once "routes/_advpr.php";
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

$app->notFound(function () use ($app) {
    if (empty($_SESSION["SERVER"]) || !isset($_SESSION["SERVER"])) {
        User::clearError();
        User::setError("database_undefined");
    }

    User::setError("page_undefined");
});

$app->run();
