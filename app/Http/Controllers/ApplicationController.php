<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    public function create($vacancyId)
    {
        $vacancy = JobVacancy::where('id', $vacancyId)
            ->where('status', 'open')
            ->firstOrFail();

        $already = Application::where('user_id', Auth::id())
            ->where('job_vacancy_id', $vacancyId)
            ->exists();

        if ($already) {
            return redirect()->route('lowongan')
                ->with('error', 'Kamu sudah pernah melamar posisi ini.');
        }

        return view('pages.guest.apply', compact('vacancy'));
    }

    public function store(Request $request, $vacancyId)
    {
        $vacancy = JobVacancy::where('id', $vacancyId)
            ->where('status', 'open')
            ->firstOrFail();

        $request->validate([
            'phone'        => 'required|string|max:20',
            'birthdate'    => 'nullable|date',
            'gender'       => 'required|in:Laki-laki,Perempuan',
            'address'      => 'required|string|max:255',
            'summary'      => 'nullable|string|max:500',
            'education'    => 'nullable|array',
            'experience'   => 'nullable|array',
            'cover_letter' => 'nullable|string|max:2000',
            'resume'       => 'required|file|mimes:pdf|max:5120',
            'documents.*'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'phone.required'  => 'Nomor telepon wajib diisi.',
            'resume.required' => 'CV wajib diupload.',
            'resume.mimes'    => 'CV harus berformat PDF.',
            'resume.max'      => 'Ukuran CV maksimal 5MB.',
        ]);

        // Cek duplikat sekali lagi (race condition guard)
        $already = Application::where('user_id', Auth::id())
            ->where('job_vacancy_id', $vacancyId)
            ->exists();

        if ($already) {
            return redirect()->route('lowongan')
                ->with('error', 'Kamu sudah pernah melamar posisi ini.');
        }

        $resumePath    = $request->file('resume')->store('resumes', 'public');
        $documentPaths = [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $doc) {
                $documentPaths[] = [
                    'name' => $doc->getClientOriginalName(),
                    'path' => $doc->store('documents', 'public'),
                ];
            }
        }

        Application::create([
            'user_id'        => Auth::id(),
            'job_vacancy_id' => $vacancyId,
            'phone'          => $request->phone,
            'birthdate'      => $request->birthdate ?: null,
            'gender'         => $request->gender ?: null,
            'address'        => $request->address ?: null,
            'summary'        => $request->summary ?: null,
            'education'      => $request->education ?: null,
            'experience'     => $request->experience ?: null,
            'cover_letter'   => $request->cover_letter ?: null,
            'resume_path'    => $resumePath,
            'documents'      => !empty($documentPaths) ? $documentPaths : null,
            'status'         => 'pending',
            'applied_at'     => now(),
        ]);

        return redirect()->route('lowongan')
            ->with('success', 'Lamaranmu berhasil dikirim! Tim HR akan menghubungimu segera.');
    }
}