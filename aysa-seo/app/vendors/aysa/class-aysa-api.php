<?php

namespace Aysa\App\Vendors\Aysa;

use Aysa\App\Vendors\Aysa\Clients\Http_Client_Factory;
use Aysa\App\Vendors\Aysa\Requests\Request_Factory;
use Aysa\App\Vendors\Aysa\Responses\Response_Factory;

class Aysa_Api
{
    private Client $client;

    private Http_Client_Factory $httpClientFactory;

    private Request_Factory $requestFactory;

    private Response_Factory $responseFactory;

    public function __construct(
        array $config = [],
        Http_Client_Factory $httpClientFactory = null,
        Request_Factory $requestFactory = null,
        Response_Factory $responseFactory = null
    ) {
        $this->httpClientFactory = $httpClientFactory ?: new Http_Client_Factory();
        $this->requestFactory = $requestFactory ?: new Request_Factory();
        $this->responseFactory = $responseFactory ?: new Response_Factory();

        $config = array_merge([
            'http_client_handler' => null,
        ], $config);

        $this->client = new Client(
            $this->httpClientFactory->create_http_client($config['http_client_handler'])
        );
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function get_suggestions(array $params)
    {
        $request = $this->requestFactory->create_request('get-suggestions');
        $request->set_params($params);

        return $this->client->send($request, $this->responseFactory->create_request('get-suggestions'));
    }

    public function get_ranks(array $params)
    {
        $request = $this->requestFactory->create_request('get-ranks');
        $request->set_params($params);

        return $this->client->send($request, $this->responseFactory->create_request('get-ranks'));
    }
}