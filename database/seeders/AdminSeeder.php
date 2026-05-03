<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin utama
        User::updateOrCreate(
            ['email' => 'admin@ntp.id'],
            [
                'first_name'        => 'Super',
                'last_name'         => 'Admin',
                'password'          => Hash::make('admin123456'),
                'role'              => 'admin',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('✅ Admin Seeder berhasil! Login: admin@ntp.id / admin123456');
    }
}

// =========================================================
// Jangan lupa panggil di DatabaseSeeder.php:
//
// public function run(): void
// {
//     $this->call([
//         HRSeeder::class,
//         AdminSeeder::class,   // tambahkan ini
//     ]);
// }
// =========================================================
