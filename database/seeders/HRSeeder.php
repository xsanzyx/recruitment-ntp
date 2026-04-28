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
                'email_verified_at' => now(),
            ]
        );

        // =============================================
        //  2. Buat beberapa lowongan
        // =============================================
        $vacancies = [
            [
                'title'        => 'Mechanical Engineer',
                'department'   => 'Engineering',
                'description'  => "Bertanggung jawab atas perancangan dan analisis komponen mekanis turbin gas.\n\nTugas utama:\n- Merancang komponen turbin menggunakan software CAD\n- Melakukan analisis kekuatan material\n- Berkoordinasi dengan tim produksi\n- Membuat laporan teknis berkala",
                'requirements' => "- S1 Teknik Mesin dari universitas terakreditasi\n- Pengalaman minimal 2 tahun di bidang terkait\n- Menguasai AutoCAD, SolidWorks, atau CATIA\n- Memahami standar ASME dan API\n- Komunikatif dan mampu bekerja dalam tim",
                'location'     => 'Bandung',
                'type'         => 'full-time',
                'status'       => 'open',
                'deadline'     => now()->addMonths(2),
                'created_by'   => $hr->id,
            ],
            [
                'title'        => 'Quality Control Inspector',
                'department'   => 'Quality Assurance',
                'description'  => "Melakukan inspeksi kualitas pada proses produksi dan produk akhir turbin.\n\nTugas utama:\n- Inspeksi dimensi dan visual komponen\n- Membuat laporan Non-Conformance Report (NCR)\n- Memastikan standar ISO 9001 terpenuhi",
                'requirements' => "- D3/S1 Teknik Mesin atau Teknik Industri\n- Pengalaman minimal 1 tahun di QC/QA\n- Memahami alat ukur (CMM, mikrometer, kaliper)\n- Memahami standar ISO 9001:2015\n- Teliti dan detail-oriented",
                'location'     => 'Bandung',
                'type'         => 'full-time',
                'status'       => 'open',
                'deadline'     => now()->addMonths(1),
                'created_by'   => $hr->id,
            ],
            [
                'title'        => 'Admin & Finance Staff',
                'department'   => 'Finance',
                'description'  => "Mengelola administrasi keuangan dan pembukuan perusahaan.\n\nTugas utama:\n- Input data transaksi keuangan\n- Membuat laporan keuangan bulanan\n- Mengelola invoice dan payment",
                'requirements' => "- S1 Akuntansi atau Manajemen Keuangan\n- Menguasai Microsoft Excel dan software akuntansi\n- Teliti dan rapi dalam pengelolaan data\n- Fresh graduate dipersilakan melamar",
                'location'     => 'Bandung',
                'type'         => 'full-time',
                'status'       => 'open',
                'deadline'     => now()->addWeeks(3),
                'created_by'   => $hr->id,
            ],
            [
                'title'        => 'IT Support (Contract)',
                'department'   => 'IT',
                'description'  => "Memberikan dukungan teknis IT untuk seluruh divisi perusahaan.",
                'requirements' => "- D3/S1 Teknik Informatika\n- Menguasai troubleshooting hardware/software\n- Memahami jaringan komputer dasar",
                'location'     => 'Bandung',
                'type'         => 'contract',
                'status'       => 'closed',
                'deadline'     => now()->addWeeks(1),
                'created_by'   => $hr->id,
            ],
        ];

        $createdVacancies = [];
        foreach ($vacancies as $v) {
            $createdVacancies[] = JobVacancy::firstOrCreate(
                ['title' => $v['title'], 'created_by' => $hr->id],
                $v
            );
        }

        // =============================================
        //  3. Buat kandidat dummy
        // =============================================
        $candidates = [
            [
                'first_name' => 'Budi', 'last_name' => 'Santoso',
                'email' => 'budi@example.com',
                'education' => 'S1', 'phone' => '081234567890',
                'gender' => 'Laki-laki', 'summary' => 'Lulusan Teknik Mesin ITB dengan pengalaman 3 tahun.',
            ],
            [
                'first_name' => 'Rina', 'last_name' => 'Wulandari',
                'email' => 'rina@example.com',
                'education' => 'S1', 'phone' => '081298765432',
                'gender' => 'Perempuan', 'summary' => 'Fresh graduate Teknik Industri UNPAD.',
            ],
            [
                'first_name' => 'Ahmad', 'last_name' => 'Fauzi',
                'email' => 'ahmad@example.com',
                'education' => 'D3', 'phone' => '085611223344',
                'gender' => 'Laki-laki', 'summary' => 'Lulusan D3 Polman Bandung, berpengalaman di QC.',
            ],
            [
                'first_name' => 'Siti', 'last_name' => 'Nurhaliza',
                'email' => 'siti@example.com',
                'education' => 'S1', 'phone' => '087855667788',
                'gender' => 'Perempuan', 'summary' => 'S1 Akuntansi, berpengalaman 2 tahun di bidang finance.',
            ],
            [
                'first_name' => 'Dani', 'last_name' => 'Pratama',
                'email' => 'dani@example.com',
                'education' => 'S2', 'phone' => '081399887766',
                'gender' => 'Laki-laki', 'summary' => 'S2 Teknik Mesin, spesialisasi turbin gas.',
            ],
            [
                'first_name' => 'Maya', 'last_name' => 'Putri',
                'email' => 'maya@example.com',
                'education' => 'SMA', 'phone' => '089977665544',
                'gender' => 'Perempuan', 'summary' => 'Lulusan SMK jurusan TKJ.',
            ],
        ];

        $createdCandidates = [];
        foreach ($candidates as $c) {
            $user = User::firstOrCreate(
                ['email' => $c['email']],
                [
                    'first_name'        => $c['first_name'],
                    'last_name'         => $c['last_name'],
                    'password'          => Hash::make('password'),
                    'role'              => 'kandidat',
                    'email_verified_at' => now(),
                ]
            );

            CandidateProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'last_education' => $c['education'],
                    'phone'          => $c['phone'],
                    'gender'         => $c['gender'],
                    'summary'        => $c['summary'],
                    'address'        => 'Bandung, Jawa Barat',
                    'birth_date'     => now()->subYears(rand(22, 35))->subDays(rand(1, 300)),
                ]
            );

            $createdCandidates[] = $user;
        }

        // =============================================
        //  4. Buat lamaran dummy
        // =============================================
        $applications = [
            // Mechanical Engineer — 3 pelamar
            ['candidate' => 0, 'vacancy' => 0, 'status' => 'review',      'notes' => 'CV bagus, jadwalkan interview.'],
            ['candidate' => 4, 'vacancy' => 0, 'status' => 'lolos',       'notes' => 'Kualifikasi sangat sesuai. Rekomendasi: lanjut ke interview user.'],
            ['candidate' => 1, 'vacancy' => 0, 'status' => 'pending',     'notes' => null],

            // QC Inspector — 2 pelamar
            ['candidate' => 2, 'vacancy' => 1, 'status' => 'review',      'notes' => 'Pengalaman di QC sudah ada, perlu cek sertifikasi.'],
            ['candidate' => 0, 'vacancy' => 1, 'status' => 'tidak_lolos', 'notes' => 'Tidak sesuai kualifikasi yang dibutuhkan.'],

            // Admin Finance — 2 pelamar
            ['candidate' => 3, 'vacancy' => 2, 'status' => 'lolos',       'notes' => 'Pengalaman finance sesuai. Direkomendasikan.'],
            ['candidate' => 1, 'vacancy' => 2, 'status' => 'pending',     'notes' => null],

            // IT Support — 1 pelamar
            ['candidate' => 5, 'vacancy' => 3, 'status' => 'pending',     'notes' => null],
        ];

        foreach ($applications as $a) {
            Application::firstOrCreate(
                [
                    'user_id'        => $createdCandidates[$a['candidate']]->id,
                    'job_vacancy_id' => $createdVacancies[$a['vacancy']]->id,
                ],
                [
                    'cover_letter' => 'Dengan hormat, saya tertarik untuk melamar posisi ' . $createdVacancies[$a['vacancy']]->title . ' di PT Nusantara Turbin dan Propulsi. Saya yakin pengalaman dan keahlian saya sesuai dengan kebutuhan perusahaan.',
                    'status'       => $a['status'],
                    'reviewed_by'  => $a['notes'] ? $hr->id : null,
                    'review_notes' => $a['notes'],
                    'applied_at'   => now()->subDays(rand(0, 14))->subHours(rand(1, 12)),
                ]
            );
        }

        $this->command->info('✅ HR Seeder berhasil! Login: hr@ntp.id / password');
    }
}
