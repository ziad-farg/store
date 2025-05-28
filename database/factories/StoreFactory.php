<?php

namespace Database\Factories;

use App\Enums\OpeningStatus;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->company();

        return [
            'name' => $name,
            'address' => $this->faker->address(),
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(4),
            'opening_status' => $this->faker->randomElement(OpeningStatus::cases())->value,
        ];
    }
}
