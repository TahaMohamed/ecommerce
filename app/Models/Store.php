<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\Filter;
use App\Traits\AssetOperation;

class Store extends Model
{
    use Filter, AssetOperation,Translatable;

    protected $guarded = ['id','created_at','updated_at'];
    protected $attributes = ['is_vat_included' => false];
    public $translatedAttributes = ['name', 'description'];

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
