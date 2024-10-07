<?php

namespace Aysa\App\Vendors\Aysa\Responses;

class Response_Factory
{
    public function create_request($endpoint)
    {
        switch ($endpoint) {
            case "get-suggestions":
                return new Get_Suggestions_Response();
            case "get-ranks":
                return new Get_Ranks_Response();
            default:
                return null;
        }
    }
}