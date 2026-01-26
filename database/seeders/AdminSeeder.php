<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@sibali.id', // Silakan ganti emailnya
            'password' => Hash::make('sibali123'), // Silakan ganti passwordnya
            'role' => 'admin',
            'package' => 'vip2', // Admin kasih akses full saja
            'phone' => '08123456789',
            'address' => 'Kantor Pusat Sibali',
            'user_category' => 'Umum',
            'is_verified' => true,
        ]);
    }
}