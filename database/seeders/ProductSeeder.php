<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        CategoryFactory::new()->count(10)
            ->has(Product::factory(rand(5, 15)))
            ->create();
    }
}
