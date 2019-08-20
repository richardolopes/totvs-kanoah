<?php

namespace Kanoah\Model;

use \Kanoah\Model;
use \Kanoah\BD\MySQL;

class Parametro extends Model
{
	public static function listParametros(): array
    {
        $mysql = new MySQL();

        return $mysql->select("SELECT parametro FROM parametro ORDER BY parametro ASC");
    }

    public static function listParametrosModulo($modulo = string): array
    {
        if (!empty($modulo))
        {
            $mysql = new MySQL();

            $resultado = $mysql->select("SELECT parametro FROM modulo AS MODU INNER JOIN modulo_parametro AS MOD_PAR ON MOD_PAR.idmodulo = MODU.id INNER JOIN parametro AS PAR ON PAR.id = MOD_PAR.idparametro WHERE MODU.modulo = :MODULO", array(
                ":MODULO" => $modulo,
            ));

            $parametros = array();

            foreach ($resultado as $value)
            {
                array_push($parametros, $value["parametro"]);
			}
			
            return $parametros;
        }
        else
        {
            throw new \Exception("EMPTY_MODULO");
        }
	}

	public static function listParametrosRotina($rotina = string): array
    {
        if (!empty($rotina))
        {
            $mysql = new MySQL();

            $resultado = $mysql->select("SELECT parametro FROM rotina AS rot INNER JOIN rotina_parametro AS rotpar ON rotpar.idrotina = rot.id INNER JOIN parametro AS PAR ON PAR.id = rotpar.idparametro WHERE rot.rotina = :ROTINA", array(
                ":ROTINA" => $rotina,
            ));

            $parametros = array();

            foreach ($resultado as $value)
            {
                array_push($parametros, $value["parametro"]);
			}
			
            return $parametros;
        }
        else
        {
            throw new \Exception("EMPTY_MODULO");
        }
	}

	public function parametro($parametro = string)
    {
        if (!empty($parametro))
        {
            $mysql = new MySQL();

            $data = $mysql->select("SELECT id, parametro FROM parametro WHERE parametro = :PARAMETRO", array(
                ":PARAMETRO" => $parametro,
            ));

            $this->setData($data[0]);
        }
        else
        {
            throw new \Exception("EMPTY_PARAMETRO");
        }
    }
	
	public function delParametroModulo($modulo = int, $parametro = int)
	{
		$sql = new MySQL();
		$sql->query("DELETE FROM modulo_parametro WHERE idmodulo = :MODULO AND idparametro = :PARAMETRO", array(
			":MODULO"=>$modulo,
			":PARAMETRO"=>$parametro
		));
	}

}
