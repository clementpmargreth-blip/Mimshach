<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
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
            'description' => $this->faker->paragraph(),
            'subtitle' => $this->faker->sentence(2),
            'image' => 'https://images.unsplash.com/photo-1559136555-9303b…d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
            'date' => $this->faker->date(),
            'location' => $this->faker->address(),
        ];
    }
}
