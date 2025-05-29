<?php

namespace Database\Factories;

use App\Models\Brand;
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
            'brand_id' => Brand::inRandomOrder()->first()->id,
            //'category_id',
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->paragraph(1),
            'technical_description' => $this->faker->paragraph(1)
        ];
    }
}
