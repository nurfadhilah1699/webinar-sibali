<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Lama di-update jadi Super Admin
        User::updateOrCreate(
            ['email' => 'admin@sibali.id'], 
            [
                'name' => 'Super Admin Sibali',
                'password' => Hash::make('@dm!nS1b@l1Super'), // Ganti dengan password yang kamu inginkan
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        // 2. Tambah Akun Finance
        User::updateOrCreate(
            ['email' => 'finance@sibali.id'],
            [
                'name' => 'Admin Finance',
                'password' => Hash::make('F1n@nc3Pass'),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );

        // 3. Tambah Akun Teacher
        User::updateOrCreate(
            ['email' => 'teacher@sibali.id'],
            [
                'name' => 'Admin Teacher',
                'password' => Hash::make('T3@ch3rP@ss'),
                'role' => 'admin',
                'is_verified' => true,
            ]
        );
    }
}