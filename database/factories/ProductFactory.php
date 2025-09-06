<?php

namespace Database\Factories;

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
        return [
            'name' => 'Product ' . fake()->randomNumber(3, true),
            'price' => fake()->randomFloat(2, 50, 5000),
            'stocks' => fake()->randomNumber(3, false)
        ];
    }
}
