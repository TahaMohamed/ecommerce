<?php

namespace App\Http\Resources\Api\Consumer;

use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResource extends JsonResource
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
            'name' => $this->product?->name,
            'description' => $this->product?->description,
            'image' => $this->product?->image,
            'price' => (float)$this->product?->price,
            'quantity' => $this->quantity,
        ];
    }
}
