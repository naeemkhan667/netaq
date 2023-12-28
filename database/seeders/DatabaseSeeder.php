<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(5)->create();
        // \App\Models\Course::factory(5)->create();
        // \App\Models\CourseStatus::factory(3)->create();
        $this->call(CourseSeeder::class);
        $this->call(CourseStatusSeeder::class);
        $this->call(UserSeeder::class);

    }
}
