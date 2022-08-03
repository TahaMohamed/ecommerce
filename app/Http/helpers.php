<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

if (!function_exists('convert_arabic_number')) {
    function convert_arabic_number($number)
    {
        $arabic_array = ['۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'];
        return strtr($number, $arabic_array);
    }
}

if (!function_exists('setting')) {
    function setting(string $attr)
    {
        if (Schema::hasTable('settings')) {
            $settings = (Cache::has('settings')) ? Cache::get('settings') : Cache::rememberForever('settings', function () {
                return Setting::get();
            });

            $setting = $settings->firstWhere('key', $attr)?->value;

            if ($attr == 'phones') {
                $setting = json_decode($setting);
            } elseif ($attr == 'phone') {
                $setting = @json_decode($setting)[0];
            }

            if ($attr == 'logo') {
                $setting = asset('storage/'. $setting);
            } elseif ($attr == 'default_image') {
                $setting = $setting ? asset('storage/'. $setting) : asset('dashboardAsset/global/images/cover/cover_sm.png');
            }

            return $setting;
        }
        return;
    }
}
