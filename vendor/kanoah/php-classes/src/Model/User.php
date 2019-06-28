<?php

namespace Kanoah\Model;

use \Kanoah\Model;

class User extends Model {
	const SESSION = "User";
	const ERROR = "UserError";

	public static function setError($msg) {
		$_SESSION[User::ERROR] = $msg;
	}

	public static function getError() {
		$msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : "";
		User::clearError();
		return $msg;
	}

	public static function clearError() {
		$_SESSION[User::ERROR] = NULL;
	}
}
