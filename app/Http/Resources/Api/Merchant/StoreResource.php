<?php

namespace App\Http\Resources\Api\Merchant;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'description' => $this->description,
            'is_vat_included' => (bool)$this->is_vat_included,
            'vat_percent' => (float)$this->vat_percent,
            'image' => $this->image,
            'shipping_cost' => (float)$this->shipping_cost,
            'products_count' => $this->products_count,
        ];
    }
}
