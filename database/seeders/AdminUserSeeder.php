<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User real', // Change to your desired admin name
            'email' => 'admin1@example.com', // Change to your desired admin email
            'password' => Hash::make('12345678'), // Change to your desired admin password
            'is_admin' => true, // Ensure the is_admin field is set to true
        ]);
    }
}
