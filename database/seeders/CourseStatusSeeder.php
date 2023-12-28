<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_statuses')->insert([
            ['course_status' => 'Select Course'],
            ['course_status' => 'Active'],
            ['course_status' => 'Completed']
        ]);
    }
}
