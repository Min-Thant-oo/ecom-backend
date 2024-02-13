<?php

namespace Database\Factories;

use App\Models\Category;
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
    public function definition()
    {
        $category_count = Category::count();
        
        return [
            'title'          => $this->faker->sentence(rand(2, 5)),
            'description'    => $this->faker->realText(rand(30, 40)),
            'category_id'    => rand(1, $category_count),
            'price'          => rand(500, 800),
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
        
    }
}
