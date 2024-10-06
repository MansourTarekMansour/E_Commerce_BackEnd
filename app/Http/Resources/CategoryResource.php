<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->file ? asset('storage/category_images/' . $this->file->url) : null, // Use the file relation
        ];

        if ($request->is('api/categories/*')) {
           
            $data['products'] = ProductSimpleResource::collection($this->whenLoaded('products'));
        }
        return $data;
    }
}
