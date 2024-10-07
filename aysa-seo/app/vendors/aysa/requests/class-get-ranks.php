<?php

namespace Aysa\App\Vendors\Aysa\Requests;

use Aysa;

require_once Aysa::get_plugin_path()  . 'app/vendors/aysa/requests/class-request-interface.php';

class Get_Ranks implements Request_Interface
{
    protected array $params;

    public function get_endpoint(): string
    {
        return 'seo/getRanks';
    }

    public function get_method(): string
    {
        return "POST";
    }

    public function get_headers(): array
    {
       return [];
    }

    public function get_params(): array
    {
        return $this->params;
    }

    public function set_params(array $requestParams): void
    {
        foreach ($requestParams as $key => $value) {
            if ($key == 'secret'){
                continue;
            }
            $this->params[$key] = $value;
        }

        $secret = $requestParams['secret'];
        $signature = hash_hmac('sha256', json_encode($this->params), $secret);
        $this->params['sig'] = $signature;
    }

    public function get_timeout(): string
    {
        return '60';
    }
}