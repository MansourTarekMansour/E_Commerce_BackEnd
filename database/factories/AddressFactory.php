<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),  // Assuming you have a CustomerFactory
            'street'      => $this->faker->streetAddress,
            'city'        => $this->faker->city,
            'state'       => $this->faker->state,
            'country'     => $this->faker->country,
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
