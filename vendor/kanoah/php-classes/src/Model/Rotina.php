<?php

namespace Kanoah\Model;

use \Kanoah\BD\MySQL;
use \Kanoah\BD\SQLServer;
use \Kanoah\BD\SQLBase;
use \Kanoah\Model;

/*
0 - PRE CONDICOES
1 - RESULTADO ESPERADO
 */

class Rotina extends Model
{
    public static function listRotinas(): array
    {
		$mysql = new MySQL();
		
		$return = $mysql->select("SELECT rotina, nome FROM rotina ORDER BY rotina ASC");
		
		for ($i = 0; $i < count($return); $i++) {
			if (empty($return[$i]["nome"])) {
				$return[$i]["nome"] = "?";
			} else {	
				$return[$i]["nome"] = str_pad(substr(utf8_encode($return[$i]["nome"]), 0, 18), 18);
			}
		}

		return $return;
    }

    public static function listRotinasModulo($modulo = string): array
    {
        if (!empty($modulo))
        {
            $mysql = new MySQL();

            $resultado = $mysql->select("SELECT ROT.rotina FROM modulo AS MODU INNER JOIN modulo_rotina as MR on MR.idmodulo = MODU.id INNER JOIN rotina as ROT on ROT.id = MR.idrotina WHERE MODU.modulo = :MODULO", array(
                ":MODULO" => $modulo,
            ));

            $rotinas = array();

            foreach ($resultado as $value)
            {
                array_push($rotinas, $value["rotina"]);
            }

            return $rotinas;
        }
        else
        {
            throw new \Exception("EMPTY_MODULO");
        }
    }

    public function rotina($rotina = string)
    {
        if (!empty($rotina))
        {
            $mysql = new MySQL();

            $data = $mysql->select("SELECT id, rotina, nome FROM rotina WHERE rotina = :ROTINA", array(
                ":ROTINA" => $rotina,
            ));

            $this->setData($data[0]);
        }
        else
        {
            throw new \Exception("EMPTY_ROTINA");
        }
    }

    public function menuRotina($modulo = string): string
    {
        $sql    = new SQLBase();
        $return = $sql->select("
			SELECT (RTRIM(MENU.M_NAME) + ' (' + RTRIM(MENU.M_MODULE) + ')' + ' > ' + RTRIM(DESCR3.N_DESC) + ' > ' + RTRIM(DESCR2.N_DESC) + ' > ' + RTRIM(DESCR.N_DESC) + ' (' + RTRIM(ROTINA.F_FUNCTION) + ')') AS 'MENU'
			FROM MPMENU_FUNCTION AS ROTINA
			JOIN MPMENU_MENU AS MENU ON MENU.M_NAME = '$modulo'
			JOIN MPMENU_ITEM AS ITEM ON ITEM.I_ID_FUNC = ROTINA.F_ID
				AND ITEM.I_ID_MENU = MENU.M_ID
			JOIN MPMENU_I18N AS DESCR ON DESCR.N_PAREN_ID = ITEM.I_ID
				AND DESCR.N_LANG = '1'
			JOIN MPMENU_ITEM AS ITEM2 ON ITEM2.I_ID = ITEM.I_FATHER
				AND ITEM2.I_ID_MENU = MENU.M_ID
			JOIN MPMENU_I18N AS DESCR2 ON DESCR2.N_PAREN_ID = ITEM2.I_ID
				AND DESCR2.N_LANG = '1'
			JOIN MPMENU_ITEM AS ITEM3 ON ITEM3.I_ID = ITEM2.I_FATHER
				AND ITEM3.I_ID_MENU = MENU.M_ID
			JOIN MPMENU_I18N AS DESCR3 ON DESCR3.N_PAREN_ID = ITEM3.I_ID
				AND DESCR3.N_LANG = '1'
			WHERE ROTINA.F_FUNCTION LIKE '".$this->getrotina()."'
        ");

        while (odbc_fetch_row($return))
        {
            $menu = odbc_result($return, "MENU");
        }

        return utf8_encode($menu);
	}
	
	public function delRotinaModulo($modulo = int, $rotina = int)
	{
		$sql = new MySQL();
		$sql->query("DELETE FROM modulo_rotina WHERE idmodulo = :MODULO AND idrotina = :ROTINA", array(
			":MODULO"=>$modulo,
			":ROTINA"=>$rotina
		));
	}

	public function delTabelaRotina($rotina = int, $tabela = int, $tipo = int)
	{
		$sql = new MySQL();
		$sql->query("DELETE FROM rotina_tabela WHERE idrotina = :ROTINA AND idtabela = :TABELA AND tipo = :TIPO", array(
			":ROTINA"=>$rotina,
			":TABELA"=>$tabela,
			":TIPO"=>$tipo
		));
	}

	public static function criarRotina($rotina): bool
	{
		if (!empty($rotina))
		{
			$rotina = strtoupper($rotina);

			$sql = new SQLBase();
			$return = $sql->select("
			SELECT RTRIM(DESCR.N_DESC) as N_DESC
			FROM MPMENU_FUNCTION AS ROTINA 
			JOIN MPMENU_MENU AS MENU ON MENU.M_NAME LIKE '%%' 
			JOIN MPMENU_ITEM AS ITEM ON ITEM.I_ID_FUNC = ROTINA.F_ID 
			AND ITEM.I_ID_MENU = MENU.M_ID 
			JOIN MPMENU_I18N AS DESCR ON DESCR.N_PAREN_ID = ITEM.I_ID 
			AND DESCR.N_LANG = '1' 
			JOIN MPMENU_ITEM AS ITEM2 ON ITEM2.I_ID = ITEM.I_FATHER 
			AND ITEM2.I_ID_MENU = MENU.M_ID 
			JOIN MPMENU_I18N AS DESCR2 ON DESCR2.N_PAREN_ID = ITEM2.I_ID 
			AND DESCR2.N_LANG = '1' 
			JOIN MPMENU_ITEM AS ITEM3 ON ITEM3.I_ID = ITEM2.I_FATHER 
			AND ITEM3.I_ID_MENU = MENU.M_ID 
			JOIN MPMENU_I18N AS DESCR3 ON DESCR3.N_PAREN_ID = ITEM3.I_ID 
			AND DESCR3.N_LANG = '1' 
			WHERE ROTINA.F_FUNCTION LIKE '$rotina'
			");

			$nome = odbc_result($return, "N_DESC");

			if (!empty($nome) && isset($nome))
			{
				$mysql = new MySQL();
				$mysql->query("INSERT INTO rotina(`rotina`, `nome`) VALUES (:ROTINA, :NOME)", array(
					":ROTINA"=>$rotina,
					":NOME"=>$nome
				));	

				return true;
			}
			else
			{
				throw new \Exception("ROTINA_NOTFOUND");
			}
		}
		else
		{
			// throw new \Exception("ROTINA_UNDEFINED");
		}
	}

	public static function parametrosRotina($rotina)
	{
		return shell_exec("py python/parametros.py $rotina");
	}

}
