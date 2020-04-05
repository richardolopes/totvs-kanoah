<?php

use \Kanoah\BD\SQLBase;
use \Slim\Slim;

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
