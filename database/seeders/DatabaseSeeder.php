<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('users')->insert([
            'name' => "Admin",
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert([
            'name' => "User",
            'email' => "user@user.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
        ]);

        DB::table('properties')->insert([
            'user_id' => 2,
            'type' => 'home',
            'description' => 'little description',
            'NoOfBeds' => 2,
            'NoOfBaths' => 1,
            'propertyFor' => 'sale',
            'longitude' => 10,
            'latitude' => 10,
            'currentStatus' => 'available for sale'
        ]);
        DB::table('properties')->insert([
            'user_id' => 2,
            'type' => 'land',
            'description' => 'little description about land',
            'NoOfBeds' => null,
            'NoOfBaths' => null,
            'propertyFor' => 'sale',
            'longitude' => 11,
            'latitude' => 11,
            'currentStatus' => 'available for sale'
        ]);
    }
}
