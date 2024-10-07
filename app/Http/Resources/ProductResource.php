<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'quantity_in_stock' => $this->quantity_in_stock,
            'quantity_sold' => $this->quantity_sold,
            'is_available' => $this->is_available,
            'rating' => $this->rating,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'images' => $this->files->map(function ($file) {
                return asset('storage/product_images/' . $file->url);
            }),
            'comments' => CommentResource::collection($this->whenLoaded('comments')), // Add this line
        ];
    }
}
