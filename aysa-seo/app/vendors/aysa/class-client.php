<?php

namespace Aysa\App\Vendors\Aysa;

use Aysa\App\Vendors\Aysa\Clients\Http_Client_Interface;
use Aysa\App\Vendors\Aysa\Requests\Request_Interface;
use Aysa\App\Vendors\Aysa\Responses\Response_Interface;

class Client
{
    const AYSA_URL = "https://app.aysa.ai/powerapi/";

    public function __construct(
        private Http_Client_Interface $httpClientHandler,
    )
    {
    }

    public function send(Request_Interface $request, Response_Interface $response): Response_Interface
    {
        $apiResponse = $this->httpClientHandler->send(
            self::AYSA_URL . $request->get_endpoint(),
            $request->get_method(),
            $request->get_params(),
            $request->get_headers(),
            $request->get_timeout()
        );

        $response->set_content($apiResponse);

        return $response;
    }
}