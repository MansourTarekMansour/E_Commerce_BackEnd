<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'discount_price' => $this->faker->randomFloat(2, 5, 900),
            'quantity_in_stock' => $this->faker->numberBetween(1, 100),
            'quantity_sold' => $this->faker->numberBetween(0, 50),
            'is_available' => $this->faker->boolean,
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'user_id' => \App\Models\User::factory(),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
        ];
    }
}
