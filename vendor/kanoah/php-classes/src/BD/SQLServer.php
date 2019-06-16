<?php

namespace Kanoah\BD;

class SQLServer {
	const DRIVER   = "SQL Server";
	const DNS 	   = "SPON5143\SQL2014";
	const DBNAME   = "P12123MNTDB";
	const USERNAME = "sa";
	const PASSWORD = "1234";

	private $conn;

	public function __construct() {
		try {
			$this->conn = odbc_connect("Driver={" . Sql::DRIVER . "};Server=" . Sql::DNS . ";Database=" . Sql::DBNAME . ";", Sql::USERNAME, Sql::PASSWORD);
		} catch (PDOException  $e) {
			die("Sem conexao com o banco de dados.");
		}
	}

	public function __destruct() {
		odbc_close($this->conn);
	}

	public function select($rawQuery) {
		$return =  odbc_exec($this->conn, $rawQuery);
		return $return;
	}
}

?>