<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'username' => 'admin1',
                'password' => bcrypt('password123'), 
                'email' => 'admin1@gmail.com',
                'created_at' => now(),
            ],
            [
                'username' => 'admin2',
                'password' => bcrypt('password123'),
                'email' => 'admin2@gmail.com',
                'created_at' => now(),
            ],
        ]);
    }
}