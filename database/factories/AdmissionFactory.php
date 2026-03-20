<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admission>
 */
class AdmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $programs = [
            'Computer Science',
            'Business Administration',
            'Medicine',
            'Law',
            'Engineering',
            'Data Science',
            'Public Health',
        ];

        return [
            'title' => $this->faker->sentence(6),
            'subtitle' => $this->faker->paragraph(2),
            'content' => $this->faker->paragraphs(3, true),
            'image' => 'https://images.unsplash.com/photo-1559136555-9303b…d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
            'program' => $this->faker->randomElement($programs),
            'year' => now()->year,
            'deadline' => $this->faker->dateTimeBetween('now', '+6 months'),
        ];
    }
}
