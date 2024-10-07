<?php

namespace Aysa\App\Vendors\Aysa\Responses;

use Aysa;

require_once Aysa::get_plugin_path()  . 'app/vendors/aysa/responses/class-response-interface.php';

class Get_Suggestions_Response implements Response_Interface
{
    private array $content;

    public function set_content($content): void
    {
        $this->content = json_decode($content, true);
    }

    public function get_content(): array
    {
        return $this->content;
    }

}