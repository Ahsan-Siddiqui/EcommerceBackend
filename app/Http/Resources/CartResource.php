<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'shop_name' => $this->shop_name,
            'address' => $this->address,
            'product_name' => $this->product_name,
            'product_price' => $this->ce,
            'product_description' => $this->product_description
        ];
    }
}
