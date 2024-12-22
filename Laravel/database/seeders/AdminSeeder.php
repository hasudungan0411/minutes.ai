<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Cari berdasarkan email
            [
                'name' => 'Admin Notulain',
                'password' => Hash::make('Adminnotulain1'), // Hash password
                'role' => 'admin', // Tambahkan jika ada kolom role
            ]
        );
    }
}
