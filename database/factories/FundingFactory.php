<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Funding>
 */
class FundingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Student Loan',
            'Personal Loan',
            'Business Loan',
            'Mortgage',
            'Scholarship',
            'Grant',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name . ' ' . $this->faker->unique()->word()),
            'description' => $this->faker->paragraph(),
            'image' => 'https://images.unsplash.com/photo-1434030216411-0b…3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
            'education_level' => $this->faker->randomElement([
                'Undergraduate',
                'Graduate',
                'MBA',
                'PHD'
            ]),
        ];
    }
}
