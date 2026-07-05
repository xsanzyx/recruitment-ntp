<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Seed demo data lengkap untuk semua role.
     * Data ini bersifat dummy untuk keperluan demonstrasi sistem.
     */
    public function run(): void
    {
        // =============================================
        //  1. SUPER ADMIN
        // =============================================
        User::updateOrCreate(
            ['email' => 'admin@ntp.co.id'],
            [
                'first_name'        => 'Super',
                'last_name'         => 'Admin',
                'password'          => Hash::make('Admin@Ntp2026'),
                'role'              => 'admin',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('✅ Super Admin  → admin@ntp.co.id / Admin@Ntp2026');

        // =============================================
        //  2. HR
        // =============================================
        $hr = User::updateOrCreate(
            ['email' => 'hr@ntp.co.id'],
            [
                'first_name'        => 'Sari',
                'last_name'         => 'Dewi',
                'password'          => Hash::make('HrNtp@2026'),
                'role'              => 'hr',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('✅ HR           → hr@ntp.co.id / HrNtp@2026');

        // =============================================
        //  3. MANAGER (per departemen)
        // =============================================
        User::updateOrCreate(
            ['email' => 'manager.mis@ntp.co.id'],
            [
                'first_name'        => 'Budi',
                'last_name'         => 'Santoso',
                'password'          => Hash::make('Manager@2026'),
                'role'              => 'manager',
                'department'        => 'MIS',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('✅ Manager MIS  → manager.mis@ntp.co.id / Manager@2026');

        User::updateOrCreate(
            ['email' => 'manager.eng@ntp.co.id'],
            [
                'first_name'        => 'Rina',
                'last_name'         => 'Wati',
                'password'          => Hash::make('Manager@2026'),
                'role'              => 'manager',
                'department'        => 'Engineering',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('✅ Manager Eng  → manager.eng@ntp.co.id / Manager@2026');

        // =============================================
        //  4. KANDIDAT (dengan profil lengkap)
        // =============================================
        $kandidat = User::updateOrCreate(
            ['email' => 'kandidat@example.com'],
            [
                'first_name'        => 'Ahmad',
                'last_name'         => 'Fauzi',
                'password'          => Hash::make('Kandidat@2026'),
                'role'              => 'user',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Profil lengkap kandidat
        CandidateProfile::updateOrCreate(
            ['user_id' => $kandidat->id],
            [
                'phone'          => '081234567890',
                'address'        => 'Jl. Merdeka No. 10, Bandung, Jawa Barat',
                'birth_date'     => '1999-05-15',
                'gender'         => 'Laki-laki',
                'last_education' => 'S1',
                'summary'        => 'Lulusan S1 Teknik Informatika dengan pengalaman magang di bidang pengembangan web. Tertarik pada pengembangan sistem informasi berbasis Laravel.',
                'gpa'            => 3.65,
                'education'      => json_encode([
                    [
                        'institution' => 'Universitas Telkom',
                        'degree'      => 'S1',
                        'field'       => 'Teknik Informatika',
                        'start_year'  => '2018',
                        'end_year'    => '2022',
                        'gpa'         => '3.65',
                    ],
                    [
                        'institution' => 'SMAN 3 Bandung',
                        'degree'      => 'SMA/SMK',
                        'field'       => 'IPA',
                        'start_year'  => '2015',
                        'end_year'    => '2018',
                        'gpa'         => '',
                    ],
                ]),
                'experience'     => json_encode([
                    [
                        'company'    => 'PT Digital Solusi',
                        'position'   => 'Web Developer Intern',
                        'start_date' => '2022-01',
                        'end_date'   => '2022-06',
                    ],
                ]),
            ]
        );
        $this->command->info('✅ Kandidat     → kandidat@example.com / Kandidat@2026');

        // =============================================
        //  5. LOWONGAN PEKERJAAN (variasi departemen & status)
        // =============================================
        $vacancy1 = JobVacancy::updateOrCreate(
            ['title' => 'IT Support Staff', 'department' => 'MIS'],
            [
                'division'           => 'Infrastructure',
                'description'        => 'Bertanggung jawab atas pengelolaan infrastruktur IT perusahaan meliputi jaringan, server, dan troubleshooting perangkat keras/lunak.',
                'requirements'       => "- Pendidikan minimal D3 Teknik Informatika/Sistem Informasi\n- Memahami jaringan komputer (LAN/WAN)\n- Familiar dengan OS Windows & Linux Server\n- Mampu troubleshooting hardware dan software\n- Memiliki sertifikasi CCNA menjadi nilai tambah",
                'type'               => 'full-time',
                'status'             => 'open',
                'deadline'           => now()->addDays(30),
                'created_by'         => $hr->id,
                'min_age'            => 21,
                'max_age'            => 35,
                'gender_requirement' => 'Semua',
                'min_education'      => 'D3',
            ]
        );

        $vacancy2 = JobVacancy::updateOrCreate(
            ['title' => 'Mechanical Engineer', 'department' => 'Engineering'],
            [
                'division'           => 'Aero Engine',
                'description'        => 'Melakukan perawatan dan perbaikan komponen mesin turbin pesawat sesuai standar internasional.',
                'requirements'       => "- Pendidikan minimal S1 Teknik Mesin\n- Pengalaman minimal 2 tahun di bidang MRO\n- Memahami standar EASA/FAA\n- Mampu membaca technical drawing\n- Bersedia bekerja shift",
                'type'               => 'full-time',
                'status'             => 'open',
                'deadline'           => now()->addDays(45),
                'created_by'         => $hr->id,
                'min_age'            => 23,
                'max_age'            => 40,
                'gender_requirement' => 'Laki-laki',
                'min_education'      => 'S1',
            ]
        );

        JobVacancy::updateOrCreate(
            ['title' => 'Admin Keuangan', 'department' => 'Finance'],
            [
                'division'           => 'Accounting',
                'description'        => 'Mengelola administrasi keuangan harian, pencatatan transaksi, dan pembuatan laporan keuangan bulanan.',
                'requirements'       => "- Pendidikan minimal D3 Akuntansi\n- Menguasai Microsoft Excel\n- Teliti dan detail-oriented\n- Pengalaman di bidang yang sama minimal 1 tahun",
                'type'               => 'contract',
                'status'             => 'closed',
                'deadline'           => now()->subDays(10),
                'created_by'         => $hr->id,
                'min_age'            => 20,
                'max_age'            => 30,
                'gender_requirement' => 'Semua',
                'min_education'      => 'D3',
            ]
        );
        $this->command->info('✅ 3 Lowongan pekerjaan berhasil di-seed');

        // =============================================
        //  6. LAMARAN (variasi status)
        // =============================================
        $profile = $kandidat->profile;

        if ($profile) {
            // Lamaran 1 — status: review (ke lowongan MIS)
            Application::updateOrCreate(
                ['user_id' => $kandidat->id, 'job_vacancy_id' => $vacancy1->id],
                [
                    'phone'       => $profile->phone,
                    'birthdate'   => $profile->birth_date,
                    'gender'      => $profile->gender,
                    'address'     => $profile->address,
                    'summary'     => $profile->summary,
                    'education'   => $profile->education,
                    'experience'  => $profile->experience,
                    'resume_path' => $profile->resume_path,
                    'documents'   => $profile->documents,
                    'status'      => 'review',
                    'is_read'     => false,
                    'reviewed_by' => $hr->id,
                    'applied_at'  => now()->subDays(5),
                ]
            );

            // Lamaran 2 — status: pending (ke lowongan Engineering)
            Application::updateOrCreate(
                ['user_id' => $kandidat->id, 'job_vacancy_id' => $vacancy2->id],
                [
                    'phone'       => $profile->phone,
                    'birthdate'   => $profile->birth_date,
                    'gender'      => $profile->gender,
                    'address'     => $profile->address,
                    'summary'     => $profile->summary,
                    'education'   => $profile->education,
                    'experience'  => $profile->experience,
                    'resume_path' => $profile->resume_path,
                    'documents'   => $profile->documents,
                    'status'      => 'pending',
                    'is_read'     => false,
                    'applied_at'  => now()->subDays(2),
                ]
            );
            $this->command->info('✅ 2 Lamaran demo berhasil di-seed');
        }

        $this->command->newLine();
        $this->command->info('🎉 Demo seeding selesai! Sistem siap digunakan.');
    }
}
