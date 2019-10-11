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

		$return = $mysql->select("SELECT modulo, nome FROM modulo ORDER BY modulo ASC");
		
		for ($i = 0; $i < count($return); $i++) {
			if (empty($return[$i]["nome"])) {
				$return[$i]["nome"] = "?";
			} else {
				$return[$i]["nome"] = str_pad(substr(utf8_encode($return[$i]["nome"]), 0, 18), 18);
			}
		}

		return $return;
	}
	
	public static function modulosComRotina(): array {
		$mysql = new MySQL();

		$return = $mysql->select("SELECT modulo, nome FROM modulo as modu JOIN modulo_rotina as rot on rot.idmodulo = modu.id ORDER BY count(modulo) ASC");
		
		for ($i = 0; $i < count($return); $i++) {
			if (empty($return[$i]["nome"])) {
				$return[$i]["nome"] = "?";
			} else {
				$return[$i]["nome"] = str_pad(substr(utf8_encode($return[$i]["nome"]), 0, 18), 18);
			}
		}

		return $return;
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

	public static function rotinasModulo($modulo)
	{
		if (!empty($modulo))
		{
			$sql = new SQLServer();
			$return = $sql->select("		
			SELECT Rtrim(ROTINA.F_FUNCTION) as F_FUNCTION
			FROM   MPMENU_FUNCTION AS ROTINA 
				JOIN MPMENU_MENU AS MENU 
					ON MENU.M_NAME LIKE '$modulo'
				JOIN MPMENU_ITEM AS ITEM 
					ON ITEM.I_ID_FUNC = ROTINA.F_ID 
						AND ITEM.I_ID_MENU = MENU.M_ID 
				JOIN MPMENU_I18N AS DESCR 
					ON DESCR.N_PAREN_ID = ITEM.I_ID 
						AND DESCR.N_LANG = '1' 
				JOIN MPMENU_ITEM AS ITEM2 
					ON ITEM2.I_ID = ITEM.I_FATHER 
						AND ITEM2.I_ID_MENU = MENU.M_ID 
				JOIN MPMENU_I18N AS DESCR2 
					ON DESCR2.N_PAREN_ID = ITEM2.I_ID 
						AND DESCR2.N_LANG = '1' 
				JOIN MPMENU_ITEM AS ITEM3 
					ON ITEM3.I_ID = ITEM2.I_FATHER 
						AND ITEM3.I_ID_MENU = MENU.M_ID 
				JOIN MPMENU_I18N AS DESCR3 
					ON DESCR3.N_PAREN_ID = ITEM3.I_ID 
						AND DESCR3.N_LANG = '1' 
			WHERE  ROTINA.F_FUNCTION LIKE '%%'  
			");

			$rotinas = array();

			while (odbc_fetch_row($return))
			{
				for ($j = 1; $j <= odbc_num_fields($return); $j++)
				{
					// $field_name = odbc_field_name($return, $j);
					// $sx3        = $sql->select("SELECT X3_TITULO FROM SX3T10 WHERE X3_CAMPO = '$field_name'");

					array_push($rotinas, odbc_result($return, "F_FUNCTION"));
				}
			}

			return $rotinas;
		}
	}

	public function adicionarRotina($modulo, $rotina)
	{
		if (!empty($modulo) && !empty($rotina))
		{
			$rotina = strtoupper($rotina);

			$mysql = new MySQL();
			$resultado = $mysql->select("SELECT id FROM rotina WHERE rotina = :ROTINA", array(
				":ROTINA"=>$rotina
			));

			if (isset($resultado[0]))
			{
				$mysql->query("INSERT INTO `modulo_rotina`(`idmodulo`, `idrotina`) VALUES (:MODULO, :ROTINA)", array(
					":MODULO"=>$modulo,
					":ROTINA"=>$resultado[0]["id"]
				));

				return true;
			}
		}
		else
		{
			throw new \Exception("EMPTY_MODULO_OU_ROTINA");
		}


	}
}
