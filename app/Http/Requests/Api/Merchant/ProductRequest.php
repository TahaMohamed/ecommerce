<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\Api\ApiMasterRequest;
use App\Models\Product;
use Illuminate\Validation\Rule;

class ProductRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
          'is_active' => 'required|boolean',
          'price' => 'required|numeric|gt:0',
          'image' => 'nullable|mimes:png,jpeg,jpg',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.name'] = [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) use($locale){
                    $product = Product::whereTranslation('name',$value,$locale)
                                        ->where('store_id',auth()->user()->store?->id)
                                        ->when($this->product,function ($q) {
                                            $q->where('products.id',"<>",$this->product);
                                        })
                                        ->exists();
                    if ($product) {
                        $fail(__('mobile.error.name_must_be_unique_on_store',['locale' => $locale]));
                    }
    
                }
            ];
            $rules[$locale.'.description'] = 'required|string|between:5,1000';
        }
        return $rules;
    }
}
