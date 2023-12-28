<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('courses')->insert([
            ['name' => 'Computer Networks'],
            ['name' => 'Operating Systems'],
            ['name' => 'Software Engineering'],
            ['name' => 'Computer Graphics'],
            ['name' => 'Machine Learning']
        ]);
    }
}
