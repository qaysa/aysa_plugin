<?php

namespace Aysa\App\Models\Config;

use Aysa;

class Language
{
    public static function get_options()
    {
        $languages =  include  __DIR__ . '/data/language.php';

        $options = [];
        foreach ($languages as $key => $language) {
            $options[$key] = $language;
        }

        return $options;
    }

    public static function get_recommended_languages()
    {
        return [
            'ro' => __('Romanian', Aysa::PLUGIN_ID),
            'en' => __('English', Aysa::PLUGIN_ID),
            'bg' => __('Bulgarian', Aysa::PLUGIN_ID),
        ];
    }
}