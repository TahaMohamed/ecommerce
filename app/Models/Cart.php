<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    // Accessories
    public function getIsVatIncludedAttribute()
    {
        return (bool) $this->store?->is_vat_included;
    }
    
    public function getVatPercentAttribute()
    {
        return $this->store?->vat_percent/100;
    }
    
    public function getShippingCostAttribute()
    {
        return $this->store?->shipping_cost;
    }

    public function getVatAmountAttribute()
    {
        return (float) $this->vat_percent * $this->price;
    }
    
    public function getSubtotalPriceAttribute()
    {
        return $this->cartProducts->sum('product_price');
    }
    
    public function getTotalPriceAttribute()
    {
        $subtotals = $this->subtotal_price;
        if($this->is_vat_included){
            return $subtotals + $this->shipping_cost;
        }
        return $subtotals + $this->shipping_cost + ($this->vat_percent * $subtotals);
    }

    public function consumer()
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }
   
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }
}
