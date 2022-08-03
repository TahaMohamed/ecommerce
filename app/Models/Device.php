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
    protected $guarded = ['id','created_at','updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
