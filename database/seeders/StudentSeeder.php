<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $years = ['2023', '2024', '2025', '2026'];
        $sections = ['BSIT 3-A', 'BSIT 3-B', 'BSIT 3-C', 'BSCS 2-A', 'BSIS 4-A'];

        for ($i = 0; $i < 50; $i++) {

            $year = $faker->randomElement($years);
            
            // Generate 5 unique random numbers
            $uniqueSuffix = $faker->unique()->numerify('#####');

            Student::create([
                'student_id' => $year . $uniqueSuffix, 
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'middle_name' => $faker->optional(0.7)->lastName(),
                'section' => $faker->randomElement($sections),
            ]);
        }
    }
}