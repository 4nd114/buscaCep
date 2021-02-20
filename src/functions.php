<?php

if (!function_exists('validateCep')) {
    /**
     * Validates ZIP code against a pattern
     * Valid entries:
     * 00000-000
     * 00000000
     *
     * @param string $cep
     * @return bool
     */
    function validateCep(string $cep) : bool
    {
        return preg_match('/^[0-9]{5}-{0,1}[0-9]{3}$/', trim($cep)) === 1 ? true : false;
    }
}

if (!function_exists('getData')) {
    /**
     * Parses data from ViaCEP webservice
     *
     * @param string $cep
     * @return array
     */
    function getData(string $cep) : array
    {
        $handler = curl_init();
        curl_setopt($handler, CURLOPT_HTTPGET, true);
        curl_setopt($handler, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));
        curl_setopt($handler, CURLOPT_URL, "https://viacep.com.br/ws/{$cep}/json/");
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($handler);
        curl_close($handler);

        return json_decode($result, true);
    }
}

if (!function_exists('getEndereco')) {
    /**
     * Gets Address using ZIP code
     *
     * @param string $cep
     * @return array
     * @throws Exception
     */
    function getEndereco(string $cep) : array
    {
        if (!validateCep($cep)) {
            throw new \Exception('O cep informádo é inválido.');
        }

        $data = getData($cep);
        if (isset($data['erro'])) {
            throw new \Exception('O cep informado não foi encontrado.');
        }

        return $data;
    }
}