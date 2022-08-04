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

    // Accessories
    public function getIsVatIncludedAttribute()
    {
        return (bool) $this->store?->is_vat_included;
    }
    
    public function getVatPercentAttribute()
    {
        return $this->store?->vat_percent/100;
    }

    public function getVatAmountAttribute()
    {
        return (float) $this->vat_percent * $this->price;
    }

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
