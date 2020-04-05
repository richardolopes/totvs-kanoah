<?php

namespace Kanoahndo\Controller;

class SQLServer
{
    const DRIVER = "SQL Server Native Client 11.0";

    private $conn;

    public function __construct($server = '', $database = '', $user = '', $password = '')
    {
        empty($server) ? $server = $_SESSION["SERVER"] : '';
        empty($database) ? $database = $_SESSION["DATABASE"] : '';
        empty($user) ? $user = $_SESSION["USER"] : '';
        empty($password) ? $password = $_SESSION["PASSWORD"] : '';

        $this->connection($server, $database, $user, $password);
    }

    public function connection($server, $database, $user, $password)
    {
        try {
            $this->conn = odbc_connect("Driver={" . SQLServer::DRIVER . "};Server=" . $server . ";Database=" . $database . ";", $user, $password);
        } catch (Exception $e) {
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

    public function query($rawQuery)
    {
        $return = odbc_exec($this->conn, $rawQuery);
        return $return;
    }
}
