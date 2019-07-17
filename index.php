<?php

session_start();

require_once "config.php";
require_once "vendor/autoload.php";

use \Kanoah\Model\Modulo;
use \Kanoah\Model\User;
use \Kanoah\Page;
use \Slim\Slim;

$app = new Slim();
$app->config("debug", true);

$app->get("/", function ()
{
    $page = new Page();
    $page->setTpl("index", array(
        "error" => User::getError(),
    ));
});

$app->notFound(function () use ($app)
{
    User::setError("page_undefined");
    header("Location: /");
    exit;
});

$app->get("/teste", function ()
{
    echo Modulo::criarModulo('SIGACTB');
});

require_once "functions.php";
require_once "_kanoah.php";
require_once "_modulo.php";
require_once "_rotina.php";

$app->run();
