<?php

namespace Kanoah\Model;

use \Kanoah\BD\SQLServer;
use \Kanoah\BD\MySQL;
use \Kanoah\Model;

class Modulo extends Model
{
    // Retorna todos os módulos.
    public static function listModulos(): array
    {
		$mysql = new MySQL();

		return $mysql->select("SELECT modulo FROM modulo ORDER BY modulo ASC");
    }

    public function modulo($modulo = string)
    {
        if (!empty($modulo))
        {
            $mysql = new MySQL();

            $data = $mysql->select("SELECT id, modulo, numero FROM modulo WHERE modulo = :MODULO", array(
                ":MODULO" => $modulo,
            ));

            $this->setData($data[0]);
        }
        else
        {
            User::setError("EMPTY_MODULO");
        }
	}
	
	public static function criarModulo($nomeModulo = string): bool
	{
		if (!empty($nomeModulo))
		{
			if ($nomeModulo == "SIGACFG") 
			{
				throw new \Exception("NO_MODULE");
			}

			$sql = new SQLServer();
			$infModulo = $sql->select("SELECT M_NAME, M_MODULE FROM MPMENU_MENU WHERE M_NAME = '$nomeModulo'");
		
			if (odbc_fetch_row($infModulo) != 1)
			{
				throw new \Exception("COUNT_MODULE");
			}
			else
			{
				$modulo = odbc_result($infModulo, "M_NAME");
				$numero = odbc_result($infModulo, "M_MODULE");
			}
			
			$mysql = new MySQL();

			$conf = $mysql->select("SELECT modulo FROM modulo WHERE modulo = :MODULO", array(
				":MODULO"=>$modulo
			));

			if (!empty($conf))
			{
				throw new \Exception("MODULO_JA_CADASTRADO");
			}

			$mysql->query("INSERT INTO modulo(modulo, numero) VALUES (:MODULO, :NUMERO)", array(
				":MODULO"=>$modulo,
				":NUMERO"=>$numero
			));			

			$conf = $mysql->select("SELECT modulo FROM modulo WHERE modulo = :MODULO", array(
				":MODULO"=>$modulo
			));

			if (!empty($conf))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			throw new \Exception("EMPTY_MODULO");
		}
	}
}
