<?php

namespace Aysa\App\Vendors\Aysa\Requests;

class Request_Factory
{
    public function create_request($endpoint)
    {
        switch ($endpoint) {
            case "get-suggestions":
                return new Get_Suggestions();
            case "get-ranks":
                return new Get_Ranks();
            default:
                return null;
        }
    }
}