<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\Merchant\StoreResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            // 'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'image' => $this->image,
            'user_type' => $this->user_type,
            'token' => $this->when($this->token, $this->token),
            'store' => $this->when($this->user_type == 'merchant', StoreResource::make($this->store)),
        ];
    }
}
