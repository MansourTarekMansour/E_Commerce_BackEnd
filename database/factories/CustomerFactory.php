<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerFactory extends Factory
{
    /**
     * The name of the model that is being generated.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Default hashed password
            'phone_number' => $this->faker->phoneNumber(), // Random phone number
            'blocked_until' => null, // By default, not blocked
        ];
    }
}
