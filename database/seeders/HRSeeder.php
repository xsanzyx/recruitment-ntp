<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HRSeeder extends Seeder
{
    /**
     * Seed data HR, lowongan, kandidat, dan lamaran untuk testing.
     */
    public function run(): void
    {
        // =============================================
        //  1. Buat user HR
        // =============================================
        $hr = User::firstOrCreate(
            ['email' => 'hr@ntp.id'],
            [
                'first_name'        => 'Sari',
                'last_name'         => 'Dewi',
                'password'          => Hash::make('password'),
                'role'              => 'hr',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ HR Seeder berhasil! Login: hr@ntp.id / password');
    }
}
