<?php

namespace App\Http\Requests\Api\Consumer;

use App\Http\Requests\Api\ApiMasterRequest;

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
            'product_id' => 'required|exists:products,id,is_active,1',
            'quantity' => 'required|integer|gte:1|lte:255'
        ];
    }
}
