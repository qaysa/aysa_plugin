<?php

namespace Aysa\App\Models\Config;

class Targeted_Country
{
    public static function get_options()
    {
        if (function_exists('WC')) {

            return WC()->countries->get_countries();
        }

        $countries = include __DIR__ . '/data/countries.php';
        $options = [];
        foreach ($countries as $key => $country) {
            $options[$key] = $country;
        }


        return $options;
    }

    public static function get_recommended_countries()
    {
        return [
            'RO' => 'Romania',
            'US' => 'United States (US)',
            'GB' => 'United Kingdom (UK)',
            'MD' => 'Moldova',
            'BG' => 'Bulgaria',
            'CA' => 'Canada',
            'AU' => 'Australia',
            'NZ' => 'New Zealand',
            'IE' => 'Ireland',
            'ZA' => 'South Africa'
        ];
    }
}
