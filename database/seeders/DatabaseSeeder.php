<?php

namespace Database\Seeders;

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
        $this->call([
            StudentSeeder::class,
        // User::factory(10)->create();
        ]);

        User::factory()->create([
            'name' => 'Professor Hernandez',
            'email' => 'jan_carlo.hernandez@gordoncollege.edu.ph',
            'password' => bcrypt('password'), 
        ]);
    }
}
