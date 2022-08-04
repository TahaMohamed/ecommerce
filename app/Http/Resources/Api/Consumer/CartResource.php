<?php

namespace App\Http\Resources\Api\Consumer;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'store' => StoreResource::make($this->store),
            'cart_products' => CartProductResource::collection($this->whenLoaded('cartProducts')),
            'total_price' => $this->total_price,
            'subtotal_price' => $this->subtotal_price,
            'is_vat_included' => $this->is_vat_included,
            'vat_percent' => $this->vat_percent,
            'vat_amount' => $this->vat_amount,
            'shipping_cost' => $this->shipping_cost,
        ];
    }
}
