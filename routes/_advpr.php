<?php

use \Kanoah\Model\Advpr;
use \Kanoah\Model\Mailer;
use \Kanoah\Page;

// release e rpo definidos
$app->get("/_automacao", function () {
    $advpr = new Advpr();
    $quebras = array();
    $mensagens = "";

    $r27 = $advpr->retExecDiario('12.1.027');
    $r25 = $advpr->retExecDiario('12.1.025');
    $r23 = $advpr->retExecDiario('12.1.023');

    count($r27["QUEBRAS"]) > 0 ? array_push($quebras, $r27) : $mensagens .= 'A execução do release 12.1.27 não foi realizada/terminada ou não tiveram quebras.       ';
    count($r25["QUEBRAS"]) > 0 ? array_push($quebras, $r25) : $mensagens .= 'A execução do release 12.1.25 não foi realizada/terminada ou não tiveram quebras.       ';
    count($r23["QUEBRAS"]) > 0 ? array_push($quebras, $r23) : $mensagens .= 'A execução do release 12.1.23 não foi realizada/terminada ou não tiveram quebras.       ';

    !empty($mensagens) ? $mensagens = "Obs.: " . $mensagens : "";

    $page = new Page(array(
        "header" => false,
        "scripts" => false,
        "footer" => false,
    ));
    $html = $page->setTpl("contents-email", array(
        "releases" => $quebras,
        "mensagens" => $mensagens,
    ), true);

    $email = new Mailer('Automação de Testes', $html);

    echo $html;
});

// GET no repositorio e release
$app->get("/_automacao/renew", function () {
    $advpr = new Advpr();
    $quebras = array();

    array_push($quebras, $advpr->retExecDiario(4, true));
    array_push($quebras, $advpr->retExecDiario(3, true));
    array_push($quebras, $advpr->retExecDiario(2, true));

    $page = new Page(array(
        "header" => false,
        "scripts" => false,
        "footer" => false,
    ));
    $html = $page->setTpl("contents-email", array(
        "releases" => $quebras,
    ), true);

    $email = new Mailer('Automação de Testes', $html);

    $page = new Page();
    $page->setTpl("email", array(
        "result" => $email,
    ));
});
