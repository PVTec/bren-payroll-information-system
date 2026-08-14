<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'HR Manager',
            'email' => 'admin@payroll.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Staff user
        User::create([
            'name' => 'Payroll Officer',
            'email' => 'staff@payroll.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        // Sample employee user
        User::create([
            'name' => 'John Employee',
            'email' => 'employee@payroll.com',
            'password' => Hash::make('password123'),
            'role' => 'employee',
        ]);
    }
}
