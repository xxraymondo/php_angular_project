<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Artwork 1',
                'description' => 'Beautiful painting with vibrant colors.',
                'price' => 299.99,
                'stock' => 10,
                'image' => 'artwork1.jpg',
                'category' => 'Paintings',
                'status' => 'active',
            ],
            [
                'name' => 'Artwork 2',
                'description' => 'Sculpture made from marble.',
                'price' => 499.99,
                'stock' => 5,
                'image' => 'artwork2.jpg',
                'category' => 'Sculptures',
                'status' => 'active',
            ],
            [
                'name' => 'Artwork 3',
                'description' => 'Photograph capturing a scenic landscape.',
                'price' => 99.99,
                'stock' => 20,
                'image' => 'artwork3.jpg',
                'category' => 'Photography',
                'status' => 'active',
            ],
            [
                'name' => 'Artwork 4',
                'description' => 'Abstract painting with intricate patterns.',
                'price' => 199.99,
                'stock' => 15,
                'image' => 'artwork4.jpg',
                'category' => 'Paintings',
                'status' => 'active',
            ],
            [
                'name' => 'Artwork 5',
                'description' => 'Bronze sculpture of a famous figure.',
                'price' => 799.99,
                'stock' => 8,
                'image' => 'artwork5.jpg',
                'category' => 'Sculptures',
                'status' => 'active',
            ],
            [
                'name' => 'Artwork 6',
                'description' => 'Black and white photograph of urban architecture.',
                'price' => 49.99,
                'stock' => 25,
                'image' => 'artwork6.jpg',
                'category' => 'Photography',
                'status' => 'active',
            ],
            [
                'name' => 'Artwork 7',
                'description' => 'Realistic oil painting of a landscape.',
                'price' => 399.99,
                'stock' => 12,
                'image' => 'artwork7.jpg',
                'category' => 'Paintings',
                'status' => 'active',
            ],
            [
                'name' => 'Artwork 8',
                'description' => 'Wooden sculpture of an animal.',
                'price' => 149.99,
                'stock' => 7,
                'image' => 'artwork8.jpg',
                'category' => 'Sculptures',
                'status' => 'active',
            ],
            [
                'name' => 'Artwork 9',
                'description' => 'Colorful abstract artwork on canvas.',
                'price' => 259.99,
                'stock' => 18,
                'image' => 'artwork9.jpg',
                'category' => 'Paintings',
                'status' => 'active',
            ],
            [
                'name' => 'Artwork 10',
                'description' => 'Macro photograph of nature details.',
                'price' => 79.99,
                'stock' => 30,
                'image' => 'artwork10.jpg',
                'category' => 'Photography',
                'status' => 'active',
            ],
        ];

        // Insert the product data into the 'products' table
        DB::table('products')->insert($products);
    }
}
