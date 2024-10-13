<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;

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
        $customers = Customer::factory()->count(20)->create(); // Assuming you have a factory for Customer

        // Create some categories and brands
        $categories = Category::factory()->count(20)->create();
        $brands = Brand::factory()->count(20)->create();
        
        // Create an array to hold products
        $products = [];

        // Create some products
        foreach (range(1, 25) as $index) {
            $product = Product::factory()->create([
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
                'user_id' => User::factory()->create()->id,
            ]);
            // Add each created product to the products array
            $products[] = $product;

            // Create comments for each product
            foreach (range(1, 3) as $commentIndex) {
                Comment::factory()->create([
                    'product_id' => $product->id,
                    'customer_id' => $customers->random()->id, // Randomly assign a customer to each comment
                    'content' => 'This is a sample comment for product ' . $product->id,
                    'rate' => rand(1, 5), // Random rating between 1 and 5
                ]);
            }
        }

        // Create 3 orders for each customer
        foreach ($customers as $customer) {
            for ($i = 0; $i < 3; $i++) {
                $order = Order::factory()->create(['customer_id' => $customer->id]);
                foreach (range(1, 3) as $itemIndex) {
                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'product_id' => $products[array_rand($products)]->id, // Randomly assign a product to each order item
                        'quantity' => rand(1, 5), // Random quantity
                    ]);
                }
            }
        }

        // Create 10 carts, each with 3 cart items for random customers
        foreach ($customers as $customer) {
            $cart = Cart::factory()->create(['customer_id' => $customer->id]);
            foreach (range(1, 3) as $cartItemIndex) {
                CartItem::factory()->create([
                    'cart_id' => $cart->id,
                    'product_id' => $products[array_rand($products)]->id, // Randomly assign a product to each cart item
                    'quantity' => rand(1, 5), // Random quantity
                ]);
            }
        }
    }
}
