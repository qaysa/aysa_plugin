<?php

namespace Aysa\App\Vendors\Aysa\Clients;

interface Http_Client_Interface
{
    /**
     * @param string $url
     * @param string $method
     * @param array $body
     * @param array $headers
     * @param string $timeOut
     *
     * @return string
     */
    public function send(string $url, string $method, array $body, array $headers, string $timeOut): string;
}