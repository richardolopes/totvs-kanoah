<?php

namespace Kanoah\BD;

class SQLServer
{
    const DRIVER = "SQL Server Native Client 11.0";

    private $conn;

    public function __construct()
    {
        $this->conexao($_SESSION["SERVER"], $_SESSION["DATABASE"], $_SESSION["USER"], $_SESSION["PASSWORD"]);
    }

    public function conexao($server, $database, $user, $password)
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
