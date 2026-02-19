<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Premium Dog Food',
            'category' => 'dog',
            'price' => 150000,
            'image' => 'dog_food.jpg',
            'description' => 'Makanan bergizi tinggi untuk anjing dewasa.'
        ]);

        Product::create([
            'name' => 'Cat Scratching Post',
            'category' => 'accessories',
            'price' => 250000,
            'image' => 'cat_toy.jpg',
            'description' => 'Tiang garukan nyaman untuk kucing kesayangan.'
        ]);

        Product::create([
            'name' => 'Multi-Vitamin Pet',
            'category' => 'vitamins',
            'price' => 85000,
            'image' => 'vitamin.jpg',
            'description' => 'Vitamin harian untuk daya tahan tubuh hewan.'
        ]);
    }
}