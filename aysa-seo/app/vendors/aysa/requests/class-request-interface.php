<?php

namespace Aysa\App\Vendors\Aysa\Requests;

interface Request_Interface
{
    /**
     * @return string
     */
    public function get_endpoint(): string;

    /**
     * @return string
     */
    public function get_method(): string;

    /**
     * @return array
     */
    public function get_headers(): array;

    /**
     * @return array
     */
    public function get_params(): array;

    /**
     * @param array $requestParams
     * @return void
     */
    public function set_params(array $requestParams): void;

    /**
     * @return string
     */
    public function get_timeout(): string;

}