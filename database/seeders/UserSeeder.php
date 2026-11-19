<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@foodorder.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jalan Admin No. 1',
        ]);

        // Customer Users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'phone' => '081234567891',
            'address' => 'Jalan Pelanggan No. 1',
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'phone' => '081234567892',
            'address' => 'Jalan Pelanggan No. 2',
        ]);

        User::create([
            'name' => 'Rahmat Hidayat',
            'email' => 'rahmat@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'phone' => '081234567893',
            'address' => 'Jalan Pelanggan No. 3',
        ]);
    }
}
