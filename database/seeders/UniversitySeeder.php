<?php

namespace Database\Seeders;

use App\Models\University;
use App\Models\Admission;
use App\Models\Funding;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        University::factory()
            ->count(5)
            ->create()
            ->each(function ($university) {

                // Admissions
                Admission::factory()
                    ->count(rand(2, 6))
                    ->create([
                        'university_id' => $university->id,
                        'country' => $university->country,
                    ]);

                // Fundings
                Funding::factory()
                    ->count(rand(1, 3))
                    ->create([
                        'university_id' => $university->id,
                    ]);
            });
    }
}
