<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => 'Mahsam Abbas',
            'email' => 'mahsamabbas@gmail.com',
            'password' => Hash::make('password'),
            'api_token' => hash('sha256', 'y4uKv64GvirOaRtqz0lPjFhWwQkccukN6hHhVdDWFqvJJs5AyftTnFTN2EWo'),
        ]);
    }
}
