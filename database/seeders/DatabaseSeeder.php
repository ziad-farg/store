<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $stores = Store::factory(5)->create();
        Category::factory(5)->create(
            [
                'parent_id' => null,
            ]
        );
        $categories = Category::factory(5)->create();
        $products = Product::factory(20)->create();

        // make faker images for stores
        $stores->each(function ($store) {
            Image::factory(1)->create([
                'imageable_id' => $store->id,
                'imageable_type' => Store::class,
            ]);
        });

        // make faker images for categories
        $categories->each(function ($category) {
            Image::factory(1)->create([
                'imageable_id' => $category->id,
                'imageable_type' => Category::class,
            ]);
        });

        // make faker images for products
        $products->each(function ($product) {
            Image::factory(1)->create([
                'imageable_id' => $product->id,
                'imageable_type' => Product::class,
            ]);
        });


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
    }
}
