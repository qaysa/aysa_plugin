<?php

namespace Aysa\App\Models\Config;

class Targeted_Device
{
    public static function get_options()
    {
        return [
            'desktop' => 'Desktop',
            'mobile' => 'Mobile'
        ];
    }
}