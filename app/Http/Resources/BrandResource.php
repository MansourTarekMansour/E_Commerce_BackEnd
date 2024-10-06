<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->file ? asset('storage/brand_images/' . $this->file->url) : null, // Use the file relation
        ];

        // Check if the request is for the show method
        if ($request->is('api/brands/*')) {
            // If it's a show request, include the products
            $data['products'] = ProductSimpleResource::collection($this->whenLoaded('products'));
        }

        return $data;
    }
}
