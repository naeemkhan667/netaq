<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'User1','email' => 'user1@gmail.com', 'password' => bcrypt('password')],
            ['name' => 'User2','email' => 'user2@gmail.com', 'password' => bcrypt('password')],
            ['name' => 'User3','email' => 'user3@gmail.com', 'password' => bcrypt('password')],
            ['name' => 'User4','email' => 'user4@gmail.com', 'password' => bcrypt('password')],
            ['name' => 'User5','email' => 'user5@gmail.com', 'password' => bcrypt('password')]
        ]);
    }
}
