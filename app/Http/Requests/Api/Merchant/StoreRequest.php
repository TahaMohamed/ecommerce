<?php

namespace App\Http\Requests\Api\Merchant;

use App\Http\Requests\Api\ApiMasterRequest;

class StoreRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
          'is_vat_included' => 'required|boolean',
          'vat_percent' => 'nullable|required_if:is_vat_included,true|numeric|lt:40',
          'shipping_cost' => 'nullable|numeric|gte:0',
          'image' => 'nullable|mimes:png,jpeg,jpg',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.name'] = 'required|string|max:100|unique:store_translations,name,'. auth()->user()->store?->id .',store_id';
            $rules[$locale.'.description'] = 'nullable|string|between:5,1000';
        }
        return $rules;
    }
}
