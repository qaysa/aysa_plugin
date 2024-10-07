<?php

namespace Aysa\App\Vendors\Aysa\Clients;

class Http_Client_Factory
{
    public function create_http_client($handler): Http_Client_Interface
    {
        if (!$handler) {
            return $this->get_default_client();
        }

        if ('curl' === $handler) {
            if (!extension_loaded('curl')) {
                throw new \Exception('The cURL extension must be loaded in order to use the "curl" handler.');
            }

            return new Curl_Http_Client();
        }

        throw new \Exception('The http client handler must be set to "curl"');
    }

    /**
     * @return Curl_Http_Client
     *
     * @throws \Exception
     */
    private function get_default_client(): Curl_Http_Client
    {
        return new Curl_Http_Client();
    }

}