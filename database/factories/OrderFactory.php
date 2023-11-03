<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Type_of_delivery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_of_delivery_id' => Type_of_delivery::factory()->create(),
            'address' => Address::factory()->create(),
            'pay_online' => fake()->boolean,
            'invoice_id' => Invoice::factory()->create()
        ];
    }
}
