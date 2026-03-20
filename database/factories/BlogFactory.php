<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraph(),
            'subtitle' => $this->faker->sentence(2),
            'featured_image' => 'https://images.unsplash.com/photo-1559136555-9303b…d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        ];
    }
}
