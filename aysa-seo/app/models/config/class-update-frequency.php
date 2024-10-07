<?php

namespace Aysa\App\Models\Config;

class Update_Frequency
{
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const BIMONTHLY = '2weeks';
    const MONTHLY = 'monthly';

    public static function get_options()
    {
        return [
            self::DAILY => __('Daily'),
            self::WEEKLY => __('Weekly'),
            self::BIMONTHLY => __('2weeks'),
            self::MONTHLY => __('Monthly')
        ];
    }
}