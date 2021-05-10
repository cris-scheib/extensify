<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    public static function getTerm($key, $user)
    {
        $terms = ['short_term', 'medium_term', 'long_term'];
        $setting = Setting::where('user_id', $user->id)
            ->where('key', $key)
            ->first();
        return $terms[$setting->value];
    }
   
}
