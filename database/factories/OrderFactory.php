<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment; // Assuming you have a Payment model

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(), // Creates a new customer for the order
            'total_amount' => $this->faker->randomFloat(2, 10, 1000), // Random amount between 10 and 1000
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']), // Random status
            'address_id' => Address::factory(),
        ];
    }
}
