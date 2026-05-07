<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function create($vacancyId)
    {
        $vacancy = JobVacancy::where('id', $vacancyId)
            ->where('status', 'open')
            ->firstOrFail();

        $user = Auth::user();

        // Cek duplikat
        $already = Application::where('user_id', $user->id)
            ->where('job_vacancy_id', $vacancyId)
            ->exists();

        if ($already) {
            return redirect()->route('lowongan')
                ->with('error', 'Kamu sudah pernah melamar posisi ini.');
        }

        // Ambil atau buat profil
        $profile = $user->profile;

        // Cek apakah profil lengkap
        if (!$profile || !$profile->isProfileComplete()) {
            $missing = $profile ? $profile->getMissingFields() : [
                'No. Telepon', 'Tanggal Lahir', 'Jenis Kelamin',
                'Domisili', 'Riwayat Pendidikan', 'IPK / Nilai Akhir', 'CV / Resume'
            ];

            return redirect()->route('profile')
                ->with('warning', 'Lengkapi profilmu terlebih dahulu sebelum melamar.')
                ->with('missing_fields', $missing);
        }

        // Cek eligibility
        $eligibility = $vacancy->checkEligibility($profile);

        return view('pages.guest.apply', compact('vacancy', 'profile', 'eligibility'));
    }

    public function store(Request $request, $vacancyId)
    {
        $vacancy = JobVacancy::where('id', $vacancyId)
            ->where('status', 'open')
            ->firstOrFail();

        $user = Auth::user();
        $profile = $user->profile;

        // Validasi profil lengkap
        if (!$profile || !$profile->isProfileComplete()) {
            return redirect()->route('profile')
                ->with('warning', 'Lengkapi profilmu terlebih dahulu.');
        }

        // Validasi eligibility
        $eligibility = $vacancy->checkEligibility($profile);
        if (!$eligibility['eligible']) {
            return redirect()->route('lowongan')
                ->with('error', 'Kamu tidak memenuhi syarat untuk lowongan ini.');
        }

        // Cek duplikat (race condition guard)
        $already = Application::where('user_id', $user->id)
            ->where('job_vacancy_id', $vacancyId)
            ->exists();

        if ($already) {
            return redirect()->route('lowongan')
                ->with('error', 'Kamu sudah pernah melamar posisi ini.');
        }

        $request->validate([
            'summary' => 'nullable|string|max:500',
        ]);

        // Buat lamaran — data diambil dari profil
        Application::create([
            'user_id'        => $user->id,
            'job_vacancy_id' => $vacancyId,
            'phone'          => $profile->phone,
            'birthdate'      => $profile->birth_date,
            'gender'         => $profile->gender,
            'address'        => $profile->address,
            'summary'        => $request->summary ?: $profile->summary,
            'education'      => $profile->education,
            'experience'     => $profile->experience,
            'resume_path'    => $profile->resume_path,
            'documents'      => $profile->documents,
            'status'         => 'pending',
            'applied_at'     => now(),
        ]);

        return redirect()->route('lowongan')
            ->with('success', 'Lamaranmu berhasil dikirim! Tim HR akan menghubungimu segera.');
    }
}