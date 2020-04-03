<?php

use \Kanoah\Model\User;

if (!isset($_SESSION["sx3"])) {
	$_SESSION["sx3"] = array();
	User::attSx3();
}