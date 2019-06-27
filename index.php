<?php

require_once "config.php";
require_once "vendor/autoload.php";

use \Slim\Slim;

$app = new Slim();
$app->config("debug", true);


require_once "functions.php";
require_once "kanoah.php";
require_once "admin.php";

$app->run();

?>