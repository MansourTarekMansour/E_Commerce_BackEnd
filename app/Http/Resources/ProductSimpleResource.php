<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'is_available' => $this->is_available,
            'rating' => $this->rating,
            'images' => $this->files->map(function ($file) {
                return asset('storage/product_images/' . $file->url);
            }),
        ];
    }
}
