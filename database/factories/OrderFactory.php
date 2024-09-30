<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Payment; // Assuming you have a Payment model
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(), // Creates a new customer for the order
            'payment_id' => Payment::factory()->create()->id, // Optionally link to a payment
            'total_amount' => $this->faker->randomFloat(2, 10, 1000), // Random amount between 10 and 1000
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']), // Random status
        ];
    }
}
