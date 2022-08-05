<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiMasterRequest;
use App\Models\Device;

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
          'device_token' => 'nullable|string|between:2,1000',
          'device_type' => 'nullable|in:'. join(',',Device::DEVICE_TYPES),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'username' => is_numeric($this->username) ? convert_arabic_number($this->username) : $this->username
        ]);
    }
}
