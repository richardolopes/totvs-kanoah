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

    public function execDiaria($release)
    {
        $release = $this->getReleases()[$release]->value;
        $rpo = $this->getRpos($release)[0]->value;
        $data = $this->getDatas($release, $rpo);

        $execucao = $this->getExec($release, $data, $rpo);

        $texto = "Release $release  |  " . $this->stringParaData($data) . " <br>";
        $texto .= $this->montaTexto($execucao);

        return $texto;
    }

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

    public function montaTexto($erros)
    {
        $rotinas = [];
        $qtd = count($erros);

        $texto = "Quantidade de quebras: $qtd <br>";
        for ($i = 0; $i < $qtd; $i++) {
            @$rotinas[$erros[$i]->rotina][0] .= 'CT' . explode('-', $erros[$i]->erro)[0];
            @$rotinas[$erros[$i]->rotina][1] += 1;
        }
        $qtdRot = count($rotinas);

        $texto .= "Quantidade de fontes : $qtdRot <br><br>";
        for ($i = 0; $i < $qtdRot; $i++) {
            $rotina = key($rotinas);
            $texto .= str_pad($rotina, 8) . ' = ' . str_pad($rotinas[$rotina][1], 2) . ' Quebra(s) (' . trim($rotinas[$rotina][0]) . ")<br>";
            next($rotinas);
        }

        return $texto;
    }
}
