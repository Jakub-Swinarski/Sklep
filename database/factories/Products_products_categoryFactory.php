<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Products_category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products_products_category>
 */
class Products_products_categoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory()->create(),
            'category_id' => Products_category::factory()->create()
        ];
    }
}
