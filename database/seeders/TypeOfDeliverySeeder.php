<?php

namespace Database\Seeders;

use App\Models\Type_of_delivery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeOfDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type_of_delivery::factory()->create([
            'name' => 'kurier'
        ]);
        Type_of_delivery::factory()->create([
            'name' => 'sklep'
        ]);
        Type_of_delivery::factory()->create([
            'name' => 'paczkomat'
        ]);
    }
}
