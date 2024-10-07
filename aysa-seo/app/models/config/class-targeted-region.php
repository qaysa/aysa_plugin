<?php

namespace Aysa\App\Models\Config;

class Targeted_Region
{
    public static function get_options()
    {
        $regions =  include  __DIR__ . '/data/subdivision.php';
        $options = [];
        foreach ($regions as $countryRegions) {
            foreach ($countryRegions as $key => $region) {
                if(!$region){
                    continue;
                }

                $options[$key] = $region;
            }

        }

        return $options;
    }
}