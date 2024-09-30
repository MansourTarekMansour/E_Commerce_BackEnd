<?php

namespace Database\Factories;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Product; // Make sure to import the Product model
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition()
    {
        return [
            'cart_id' => Cart::factory(), // Create a cart for each cart item
            'product_id' => Product::factory(), // Create a product for each cart item
            'quantity' => $this->faker->numberBetween(1, 5), // Random quantity between 1 and 5
        ];
    }
}
