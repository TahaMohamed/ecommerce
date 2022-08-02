<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\Filter;
use App\Traits\AssetOperation;

class Product extends Model
{
    use Filter, AssetOperation,Translatable;

    protected $guarded = ['id','created_at','updated_at'];
    public $translatedAttributes = ['name', 'description'];

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, CartProduct::class)->withPivot('quantity');
    }
}
