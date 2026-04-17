<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'grgprabesh888@gmail.com',
            'phone' => '9816618275',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create Vendor User
        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@gmail.com',
            'phone' => '9876543210',
            'role' => 'vendor',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create Customer User
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'phone' => '5555555555',
            'role' => 'customer',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create Test Customer User (mentioned in context)
        User::create([
            'name' => 'Test Customer',
            'email' => 'testcustomer@example.com',
            'phone' => '1111111111',
            'role' => 'customer',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);

        // Create another test customer
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '2222222222',
            'role' => 'customer',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
