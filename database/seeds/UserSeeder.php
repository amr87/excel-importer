<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'MidEastSoft Admin',
            'email' => 'admin@mideastsoft.com',
            'password' => Hash::make('secret'),
            'remember_token' => Str::random(10),
        ]);
    }
}
