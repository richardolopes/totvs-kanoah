<?php

use \Kanoah\Model\Modulo;
use \Kanoah\Model\Rotina;
use \Kanoah\Model\Tabela;
use \Kanoah\Model\Kanoah;
use \Kanoah\Model\User;
use \Kanoah\Page;

$app->get("/v2/kanoah", function ()
{
    $modulos = Modulo::listModulos();

    $page = new Page();
    $page->setTpl("v2-kanoah", array(
        "modulos" => $modulos,
    ));
});

$app->post("/v2/kanoah/rotina", function ()
{
    if (empty($_POST["modulo"]))
    {
        User::setError("EMPTY_POSTMODULO");
    }

    if (empty($_POST["rotina"]))
    {
        User::setError("EMPTY_POSTROTINA");
    }

    $modulo = new Modulo();
    $modulo->modulo($_POST["modulo"]);

    $rotina = new Rotina();
    $rotina->rotina($_POST["rotina"]);
    $page = new Page();
    $page->setTpl("v2-kanoah-rotina", array(
        "modulo"  => $modulo->getmodulo(),
        "rotina"  => $rotina->getrotina()
    ));
});