<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfRecords = 100000;

        $categories = Category::pluck('id')->toArray();

        if (empty($categories)) {
            $this->createCategories();
            $categories = Category::pluck('id')->toArray();
        }

        for ($i = 0; $i < $numberOfRecords; $i++) {
            $product = Product::create([
                'name' => fake()->word,
                'description' => fake()->sentence,
                'price' => fake()->randomFloat(2, 1, 1000),
            ]);

            $product->categories()->attach(fake()->randomElement($categories));

            $this->createProductImages($product, fake()->randomNumber(1, 5));
        }
    }

    private function createCategories()
    {
        $categories = ['Category 1', 'Category 2', 'Category 3'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }

    private function createProductImages(Product $product, $numberOfImages)
    {
        for ($i = 0; $i < $numberOfImages; $i++) {
            $imagePath = fake()->imageUrl(800, 600);

            $productImage = new ProductImage([
                'image_path' => $imagePath,
            ]);

            $product->images()->save($productImage);
        }
    }
}
