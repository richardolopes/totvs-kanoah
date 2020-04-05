<?php

namespace Kanoah\Model;

set_time_limit(300);

use \Kanoah\Model;

class Advpr extends Model
{
    const RELEASE = 'http://10.171.78.41:8006/rest/filtrosportal/releas/homolog';
    const RPOS = 'http://10.171.78.41:8006/rest/filtrosportal/identi/homolog/'; // 12.1.023
    const PAIS = 'http://10.171.78.41:8006/rest/filtrosportal/pais/homolog/'; // 12.1.023/RPO_D-1
    const DATAS = 'http://10.171.78.41:8006/rest/filtrosportal/BRA/execDay/'; // 12.1.023/RPO_D-1/Todas
    const EXECUCAO = 'http://10.171.78.41:8006/rest/acompanhamentoExecucaoD1/Detail/FINANCEIRO/BRA/'; // 12.1.027/20200402/RPO_D-1/Todas

    public function getExec($release, $data, $rpo)
    {
        $ch = curl_init(Advpr::EXECUCAO . $release . '/' . $data . '/' . $rpo . '/Todas');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'user' => '',
            ],
        ]);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;
    }

    public function getRpos($release)
    {
        $ch = curl_init(Advpr::RPOS . $release);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;
    }

    public function getDatas($release, $rpo)
    {
        $ch = curl_init(Advpr::DATAS . $release . '/' . $rpo . '/Todas');
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $this->maiorData($response);
    }

    public function getReleases()
    {
        $ch = curl_init(Advpr::RELEASE);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;
    }

    public function maiorData($range)
    {
        $aux = '';

        for ($i = 0; $i < count($range); $i++) {
            if ($range[$i]->value > $aux) {
                $aux = $range[$i]->value;
            }
        }

        return $aux;
    }

    public static function stringParaData($string)
    {
        return substr($string, 6, 8) . '/' . substr($string, 4, 2) . '/' . substr($string, 0, 4);
    }

    public function getQuebras($erros)
    {
        $exec = [];
        !empty($erros) ? $total = count($erros) : $total = 0;

        for ($i = 0; $i < $total; $i++) {
            $rotina = $erros[$i]->rotina;

            if (!isset($exec[$rotina])) {
                $exec[$rotina] = array(
                    "CTS" => "",
                    "TOTAL" => 0,
                );
            }

            $exec[$rotina]["CTS"] .= 'CT' . explode('-', $erros[$i]->erro)[0];
            $exec[$rotina]["TOTAL"] += 1;
        }

        return array(
            "QUEBRAS" => $exec,
            "TOTAL" => $total,
        );
    }

    public function retExecDiario($release, $rpo = false)
    {
        is_int($release) ? $release = $this->getReleases()[$release]->value : '';
        $rpo ? $rpo = $this->getRpos($release)[0]->value : $rpo = 'RPO_D-1';

        $data = $this->getDatas($release, $rpo);

        // if (isset($_SESSION["EXEC_DATA_$release"])) {
        //     if ($data == $_SESSION["EXEC_DATA_$release"]) {
        //         return "A execução da release $release está na mesma data do último e-mail enviado.";
        //     }
        // }

        $execucao = $this->getExec($release, $data, $rpo);
        $erros = $this->getQuebras($execucao);

        $return = array(
            "RELEASE" => $release,
            "DATA" => $this->stringParaData($data),
            "QUEBRAS" => $erros["QUEBRAS"],
            "TOTAL_QUEBRAS" => $erros["TOTAL"],
            "TOTAL_FONTES" => count($erros["QUEBRAS"]),
        );

        $_SESSION["EXEC_EXECUCAO_$release"] = $execucao;
        $_SESSION["EXEC_RELEASE_$release"] = $release;
        $_SESSION["EXEC_RPO_$release"] = $rpo;
        $_SESSION["EXEC_DATA_$release"] = $data;
        $_SESSION["EXEC_RETURN_$release"] = $return;

        return $return;
    }
}
