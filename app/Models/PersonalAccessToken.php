<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Illuminate\Support\Str;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $guarded = ['created_at', 'updated_at'];

    /**
    * Boot function from Laravel.
    */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
    /**
    * Get the value indicating whether the IDs are incrementing.
    *
    * @return bool
    */
    public function getIncrementing()
    {
        return false;
    }
    /**
    * Get the auto-incrementing key type.
    *
    * @return string
    */
    public function getKeyType()
    {
        return 'string';
    }
}
