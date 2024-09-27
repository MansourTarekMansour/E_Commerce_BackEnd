<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Customer;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
        ]);
        
        // Create some customers
        $customers = Customer::factory()->count(10)->create(); // Assuming you have a factory for Customer

        // Create some categories and brands
        $categories = Category::factory()->count(10)->create();
        $brands = Brand::factory()->count(10)->create();

        // Create an array to hold products
        $products = [];

        // Create some products
        foreach (range(1, 15) as $index) {
            $product = Product::factory()->create([
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'user_id' => User::factory()->create()->id,
            ]);
            // Add each created product to the products array
            $products[] = $product;
        }

        // Create comments for the products
        foreach ($products as $product) {
            Comment::factory()->count(3)->create([
                'product_id' => $product->id,
                'customer_id' => $customers->random()->id, // Randomly assign a customer to each comment
                'content' => 'This is a sample comment for product ' . $product->id,
                'rate' => rand(1, 5), // Random rating between 1 and 5
            ]);
        }
    }
}
