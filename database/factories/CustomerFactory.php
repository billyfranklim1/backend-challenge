<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'birthdate' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'address' => $this->faker->address,
            'complement' => $this->faker->word,
            'neighborhood' => $this->faker->word,
            'zipcode' => $this->faker->postcode,
        ];
    }
}
