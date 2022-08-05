<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiMasterRequest;

class LogoutRequest extends ApiMasterRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device_token' => 'nullable|exists:devices,device_token,device_type,'. $this->device_type,
            'device_type' => 'nullable|exists:devices,device_type,device_token,'. $this->device_token,
        ];
    }
}
