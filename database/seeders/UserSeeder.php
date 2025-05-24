<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    User::create([
        'name' => 'Lilly John',
        'email' => 'lilly@example.com',
        'password' => Hash::make('password'),
        'role' => 'author',
    ]);
    User::create([
        'name' => 'John Doe',
        'email' => 'johndoe@cms.com',
        'password' => Hash::make('password'),
        'role' => 'author',
    ]);
}

}
