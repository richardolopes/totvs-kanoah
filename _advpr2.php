<?php

use \Kanoah\Model\Advpr;
use \Kanoah\Model\Mailer;
use \Kanoah\Page;

$app->get("/_automacao", function () {
    $advpr = new Advpr();
    $texto = $advpr->execDiaria(4);
    $texto .= '<br><br>';
    $texto .= '<hr>';
    $texto .= '<br><br>';
    $texto .= $advpr->execDiaria(3);
    $texto .= '<br><br>';
    $texto .= '<hr>';
    $texto .= '<br><br>';
    $texto .= $advpr->execDiaria(2);
	$subject = substr($texto, 19, 10);
	
    $email = new Mailer($subject, '<h3>' . $texto . '</h3>');

    $page = new Page();
    $page->setTpl("email", array(
        "texto" => $texto,
        "email" => $email,
    ));
});
