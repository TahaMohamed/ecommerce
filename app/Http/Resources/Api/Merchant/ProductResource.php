<?php

namespace App\Http\Resources\Api\Merchant;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => (float)$this->price,
            'is_vat_included' => $this->is_vat_included,
            'vat_percent' => $this->vat_percent,
            'vat_amount' => $this->vat_amount,
        ];
    }
}
