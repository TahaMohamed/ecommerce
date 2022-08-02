<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public const IOS = 'ios';
    public const ANDROID = 'android';
    public const HUAWEI = 'huawei';
    public const DEVICE_TYPES = [
        self::IOS,self::ANDROID, self::HUAWEI
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
