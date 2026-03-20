<?php

namespace Database\Factories;

use Alirezasedghi\LaravelImageFaker\Services\Picsum;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\University>
 */
class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => $this->faker->company() . ' University',
            'subtitle' => $this->faker->paragraph(2),
            'content' => $this->faker->paragraphs(6, true),
            'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'logo' => 'https://unsplash.com/photos/a-coat-of-arms-on-the-side-of-a-building-Aq90YhjYqrk'
        ];
    }
}
