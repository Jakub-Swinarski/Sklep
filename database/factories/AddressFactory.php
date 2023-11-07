<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'zipcode' => fake()->randomNumber(5),
            'number' => fake()->randomNumber(9),
            'user_id' => User::factory()->create()
        ];
    }
}
