<?php

namespace App\Http\Requests\Api\Consumer;

use App\Http\Requests\Api\ApiMasterRequest;
use App\Models\Product;

class CartRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => ['required','exists:products,id,is_active,1',function ($attribute, $value, $fail) {
                $product = Product::with('store')->find($value);
                if ($product?->store?->is_active) {
                    $fail(__('mobile.error.page_not_found'));
                }
            }],
            'quantity' => 'required|integer|gte:1|lte:255'
        ];
    }
}
