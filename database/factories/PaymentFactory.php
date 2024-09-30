<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Customer; // Assuming you have a Customer model
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(), // Create a new customer for the payment
            'amount' => $this->faker->randomFloat(2, 1, 1000), // Random amount between 1 and 1000
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']), // Random payment method
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']), // Random status
            'transaction_id' => $this->faker->uuid(), // Generate a random transaction ID
        ];
    }
}
