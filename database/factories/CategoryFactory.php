<?php

namespace Database\Factories;

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
    public function definition()
    {

        $name = $this->faker->words(rand(1, 2), true);

        return [
            'name'           => $name,
            'slug'           => $this->getSlug($name),
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }

    private function getSlug($name)
    {
        $id = $this->faker->unique()->randomNumber(); // Generate a unique ID
        $slug = $id . '-' . Str::slug($name); // Concatenate ID with name and generate slug
        return $slug;
    }
}
