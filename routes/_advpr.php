<?php

use \Kanoah\Model\Advpr;
use \Kanoah\Model\Mailer;
use \Kanoah\Page;

// release e rpo definidos
$app->get("/_automacao", function () {
    $advpr = new Advpr();
    $quebras = array();
    $mensagens = "";

    $rpo = 'RPO_D-1';

    $data27 = $advpr->getDatas('12.1.027', $rpo);
    $data25 = $advpr->getDatas('12.1.025', $rpo);
    $data23 = $advpr->getDatas('12.1.023', $rpo);

    $r27 = $advpr->retExecDiario('12.1.027', $rpo, $data27, 'FINANCEIRO');
    $r25 = $advpr->retExecDiario('12.1.025', $rpo, $data25, 'FINANCEIRO');
    $r23 = $advpr->retExecDiario('12.1.023', $rpo, $data23, 'FINANCEIRO');

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
        "header" => "Automação de Testes",
        "releases" => $quebras,
        "mensagens" => $mensagens,
    ), true);

    $email = new Mailer('Automação de Testes', $html);

    echo $html;
});
