<?php

namespace Kanoah\BD;

class SQLCongelada
{
    const DRIVER   = "SQL Server";
    const DNS      = "SPON004928\DEVELOPER2014";
    const DBNAME   = "CONGELADA";
    const USERNAME = "sa";
    const PASSWORD = "1234";

    private $conn;

	public function __construct() {
		try {
            $this->conn = odbc_connect("Driver={" . SQLCongelada::DRIVER . "};Server=" . SQLCongelada::DNS . ";Database=" . SQLCongelada::DBNAME . ";", SQLCongelada::USERNAME, SQLCongelada::PASSWORD);
        }
        catch (Exception $e)
        {
            die("Sem conexao com o banco de dados.");
        }
	}

    public function __destruct()
    {
        odbc_close($this->conn);
    }

    public function select($rawQuery)
    {
        $return = odbc_exec($this->conn, $rawQuery);
        return $return;
    }
}
