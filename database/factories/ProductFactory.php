<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

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
