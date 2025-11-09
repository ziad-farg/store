<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->productName;

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'store_id' => Store::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'price' => $this->faker->randomFloat(1, 1, 499),
            'compare_price' => $this->faker->randomFloat(1, 500, 1000),
            'quantity' => $this->faker->numberBetween(100, 1000),
            'options' => $this->faker->optional()->randomElement([
                ['color' => 'red'],
                ['size' => 'M'],
                ['color' => 'blue', 'size' => 'L'],
                null,
            ]),
            'rating' => $this->faker->numberBetween(0, 5),
            'featured' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(ProductStatus::cases())->value,
            'description' => $this->faker->sentence(4),
        ];
    }
}
