<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\ApiMasterRequest;

class LoginRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'username' => 'required',
          'password' => 'required',
          'device_token' => 'required|string|between:2,10000',
          'type' => 'required|in:ios,android',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'username' => is_numeric($this->username) ? filter_mobile_number($this->username) : $this->username
        ]);
    }
}
