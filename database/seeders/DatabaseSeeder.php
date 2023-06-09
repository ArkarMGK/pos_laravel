<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '09796789321',
            'address' => 'Pyay',
            'role' => 'admin',
            'gender' => 'male',
            'password' => Hash::make('andromeda')
        ]);

        User::create([
            'name' => 'testuser',
            'email' => 'testuser@gmail.com',
            'phone' => '09796789321',
            'address' => 'MDY',
            'role' => 'user',
            'gender' => 'female',
            'password' => Hash::make('andromeda')
        ]);

        \App\Models\User::factory(5)->create();

    }
}
