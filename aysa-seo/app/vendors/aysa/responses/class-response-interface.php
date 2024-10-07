<?php

namespace Aysa\App\Vendors\Aysa\Responses;

interface Response_Interface
{
    /**
     * @param $content
     * @return void
     */
    public function set_content( $content): void;

    /**
     * @return array
     */
    public function get_content(): array;
}