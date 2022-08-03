<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiMasterRequest;

class VerifyAccountRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'phone' => 'required|numeric|digits_between:10,15|exists:users,phone,phone_verified_at,NULL',
          'verified_code' => 'required|size:4|exists:users,verified_code,phone,'.$this->phone
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => convert_arabic_number($this->phone)
        ]);
    }
}
