<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    protected static function boot()
    {
        parent::boot();
        static::deleted(function ($data) {
            $cart_products_count = $data->cart->cartProducts()->exists();
            if(!$cart_products_count){
                $data->cart->delete();
            }
        });
    }
    
    public function getProductPriceAttribute()
    {
        return $this->product->price * $this->quantity;
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
