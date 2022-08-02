<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function consumer()
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }
}
