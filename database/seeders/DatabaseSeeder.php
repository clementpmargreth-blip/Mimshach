<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->has(Blog::factory(10))->create([
            'name' => 'Danny',
            'email' => 'ubahchuks91@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '09051776591',
        ]);

        Event::factory(12)->create();

        $this->call([
            UniversitySeeder::class,
        ]);
    }
}
