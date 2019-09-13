<?php

$diretorio = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "fonte.txt";

$teste = fopen($diretorio, "r");


echo "<textarea>$teste</textarea>";
