<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         Product::factory(2)
             ->sequence(
                 [
                     'name' => 'Offre basique',
                     'stripe_product_id' => 'price_1OhvkACmRtsFb4LyyoVGgRTQ',
                     'price' => 9.99,
                 ],
                 [
                     'name' => 'Offre premium',
                     'stripe_product_id' => 'price_1OhvkACmRtsFb4LyjXjpxMog',
                     'price' => 19.99,
                 ]
             )
             ->create();
    }
}
