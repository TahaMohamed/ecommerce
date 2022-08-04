<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use App\Traits\Filter;
use App\Traits\AssetOperation;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filter, AssetOperation;

    protected $guarded = ['id','created_at','updated_at'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime','phone_verified_at' => 'datetime'];

    // Setter & Getter Attributes
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function getHasRightsToAccessAttribute()
    {
        return $this->is_active && ! $this->is_ban;
    }
    // Scopes
    public function scopeActive($query)
    {
        $query->where(['is_active' => true , 'is_ban' => false]);
    }

    public function store()
    {
        return $this->hasOne(Store::class, 'merchant_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'consumer_id');
    }
    
    
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
