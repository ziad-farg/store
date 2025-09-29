<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // i use package faker to generate avatar image called "mbezhanov/laravel-faker-provider-collection"
        $name = fake()->unique()->department;
        // when use $this->faker->unique()->department; that's not work

        return [
            'store_id' => Store::inRandomOrder()->first()->id,
            'parent_id' => Category::inRandomOrder()->first()?->id ?? null,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(4),
        ];
    }
}
