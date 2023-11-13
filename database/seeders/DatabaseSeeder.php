<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Orders_product;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Products_category;
use App\Models\Products_products_category;
use App\Models\Rating;
use App\Models\Type_of_delivery;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Products_category::factory(10);
        Address::factory(10)->create();
        Product::factory(10)->create();
        Products_category::factory(10)->create();
        Product_image::factory(10)->create();

        Type_of_delivery::factory(10)->create();
        Order::factory(10)->create();
        Orders_product::factory(10)->create();
        Product_image::factory(5)->create([
            'product_id' => 1
        ]);
        Products_products_category::factory(10)->create([
            'product_id'=> 1
        ]);
        Rating::factory(10)->create([
            'product_id' => 1
        ]);
        Orders_product::factory(1)->create([
            'product_id' => 1,
            'order_id' => 1
        ]);
        Orders_product::factory(1)->create([
            'order_id' => 1
        ]);
    }
}
