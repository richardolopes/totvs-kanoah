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
    $subject = substr($texto, 0, 31);

    $texto .= '<br><br><br><br><br>';
    $texto .= '<hr>';
    $texto .= 'Em desenvolvimento';

    $email = new Mailer($subject, '<h3>' . $texto . '</h3>');

    $page = new Page();
    $page->setTpl("email", array(
        "texto" => $texto,
        "email" => $email,
    ));
});
