<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product; // Assuming you have a Product model
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => Order::factory(), // Create a new order for the order item
            'product_id' => Product::factory(), // Create a new product for the order item
            'quantity' => $this->faker->numberBetween(1, 5), // Random quantity between 1 and 5
            'price' => $this->faker->randomFloat(2, 1, 100), // Random price between 1 and 100
        ];
    }
}
