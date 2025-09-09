<?php

namespace Database\Factories;

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
        $name = fake()->department;

        return [
            'parent_id' => Category::inRandomOrder()->first()?->id ?? null,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(4),
        ];
    }
}
