<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
  use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run()
    {
        // Check if the root user already exists, if not, create it
        User::firstOrCreate(
            ['username' => 'root'],
            [
                'email' => 'root123',
                'username' => 'root',
                'password' => bcrypt('rootpassword'), // Adjust the password as needed
                'role' => 'admin'
            ]
        );
    }
}

