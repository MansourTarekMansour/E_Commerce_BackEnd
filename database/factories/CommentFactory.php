<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User; // Assuming you want to use the User model
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'customer_id' => Customer::factory(), // Assuming you have a User model
            'content' => $this->faker->sentence,
            'rate' => $this->faker->numberBetween(1, 5),
        ];
    }
}