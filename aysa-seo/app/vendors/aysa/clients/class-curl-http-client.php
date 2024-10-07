<?php

namespace  Aysa\App\Vendors\Aysa\Clients;

use Exception;

class Curl_Http_Client implements Http_Client_Interface
{
    /**
     * @inheritDoc
     */
    public function send(string $url, string $method, array $body, array $headers, string $timeOut): string
    {
        $options = [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $this->getRequestHeaders($headers),
            CURLOPT_URL => $url,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => $timeOut,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        if ($method !== 'GET') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($body);
        }

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $result = curl_exec($curl);

        if (!$result){
            throw new Exception(
                "There was a problem with your request."
            );
        }
        if($error = curl_errno($curl)){
            throw new Exception(
                "There was a problem with your request: ". $error
            );
        }
        curl_close($curl);

        return $result;
    }

    /**
     * @param array $headers
     * @return array
     */
    private function getRequestHeaders(array $headers): array
    {
        $requestHeaders = [];

        foreach ($headers as $key => $value) {
            $requestHeaders[] = $key . ': ' . $value;
        }

        return $requestHeaders;
    }
}