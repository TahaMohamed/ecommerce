<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiMasterRequest;

class RegisterRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $locales = config('translatable.locales');
        $rules = [
          'name' => 'required|string|max:100',
          'phone' => 'required|numeric|digits_between:10,15|unique:users,phone',
          'email' => 'nullable|email|max:100|unique:users,email',
          'image' => 'nullable|mimes:png,jpeg,jpg',
          'password' => 'required|min:6|max:100',
          'user_type' => 'required|in:consumer,merchant',
        ];
        if($this->user_type == 'merchant'){
            $rules['store'] = 'required|array|size:' . count($locales);
            foreach ($locales as $locale) {
                $rules['store.' .$locale. '.name'] = 'required|string|max:10|unique:store_translations,name';
            }
        }

        return $rules;

    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => convert_arabic_number($this->phone)
        ]);
    }
}
