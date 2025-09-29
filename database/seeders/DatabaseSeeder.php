<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Image;
use App\Models\Store;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Category;
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

        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
        ]);

        $users = User::all();

        foreach ($users as $user) {
            Profile::factory()->create(['user_id' => $user->id]);
        }


        // make faker images for profiles
        Profile::each(function ($profile) {
            Image::factory(1)->create([
                'imageable_id' => $profile->user_id,
                'imageable_type' => Profile::class,
            ]);
        });
    }
}
