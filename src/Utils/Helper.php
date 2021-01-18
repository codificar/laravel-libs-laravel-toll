<?php

namespace Codificar\Toll\Utils;

use Settings;

class Helper
{
    public static function getIsTollActive()
    {
        $setting = Settings::where('key', 'is_toll_active')->first();

        if ($setting)
            return $setting->value;
        
        return 0;
    }

    public static function getApplyInEstimate()
    {
        $setting = Settings::where('key', 'apply_toll_in_estimate')->first();

        if ($setting)
            return $setting->value;
        
        return 0;
    }
}