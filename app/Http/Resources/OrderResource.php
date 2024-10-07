<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'customer' => new CustomerResource($this->whenLoaded('customer')), // Assumes you have a CustomerResource
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')), // Assumes you have an OrderItemResource
            'address' => new AddressResource($this->whenLoaded('address')), // Assumes you have an AddressResource
            //'payment' => new PaymentResource($this->whenLoaded('payment')), // Assumes you have a PaymentResource
        ];
    }
}
