<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\CandidateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new CandidateProfile();

        $applications = Application::with('jobVacancy')
            ->where('user_id', $user->id)
            ->latest('applied_at')
            ->get();

        // Mark semua sebagai sudah dibaca
        Application::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('pages.guest.profile', compact('user', 'profile', 'applications'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // ── Validasi User Fields ──
        $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'bio'           => 'nullable|string|max:500',
            'portfolio_url' => ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|www\.)/i'],
            'linkedin_url'  => ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|www\.)/i'],
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'last_name.required'  => 'Nama belakang wajib diisi.',
            'portfolio_url.regex' => 'URL portfolio harus diawali https:// atau www.',
            'linkedin_url.regex'  => 'URL LinkedIn harus diawali https:// atau www.',
        ]);

        // ── Validasi Profile Fields ──
        $request->validate([
            'phone'         => 'nullable|string|max:20',
            'birth_date'    => 'nullable|date',
            'gender'        => 'nullable|in:Laki-laki,Perempuan',
            'address'       => 'nullable|string|max:255',
            'summary'       => 'nullable|string|max:500',
            'education'     => 'nullable|array',
            'experience'    => 'nullable|array',
            'resume'        => 'nullable|file|mimes:pdf|max:5120',
            'documents.*'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'resume.mimes' => 'CV harus berformat PDF.',
            'resume.max'   => 'Ukuran CV maksimal 5MB.',
        ]);

        // ── Update User Data ──
        $userData = [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'bio'           => $request->bio,
            'portfolio_url' => $request->portfolio_url,
            'linkedin_url'  => $request->linkedin_url,
        ];

        // Handle avatar dari base64 crop
        if ($request->filled('avatar_cropped')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $base64    = $request->avatar_cropped;
            $base64    = str_replace('data:image/jpeg;base64,', '', $base64);
            $base64    = str_replace(' ', '+', $base64);
            $imageData = base64_decode($base64);
            $filename  = 'avatars/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $imageData);
            $userData['avatar'] = $filename;
        }

        $user->update($userData);

        // ── Update / Create Candidate Profile ──
        $profile = $user->profile ?? new CandidateProfile(['user_id' => $user->id]);

        $profileData = [
            'phone'      => $request->phone,
            'birth_date' => $request->birth_date,
            'gender'     => $request->gender,
            'address'    => $request->address,
            'summary'    => $request->summary,
            'education'  => $this->cleanEducation($request->education),
            'experience' => $this->cleanExperience($request->experience),
        ];

        // Tentukan last_education dan GPA dari entry pendidikan tertinggi
        if (!empty($profileData['education'])) {
            $hierarchy = ['SMA/SMK' => 1, 'D3' => 2, 'S1' => 3, 'S2' => 4, 'S3' => 5];
            $highest = null;
            $highestRank = 0;
            $highestGpa = null;
            foreach ($profileData['education'] as $edu) {
                $rank = $hierarchy[$edu['level'] ?? ''] ?? 0;
                if ($rank > $highestRank) {
                    $highestRank = $rank;
                    $highest = $edu['level'];
                    $highestGpa = $edu['gpa'] ?? null;
                }
            }
            if ($highest) {
                $profileData['last_education'] = $highest;
            }
            if ($highestGpa) {
                $profileData['gpa'] = $highestGpa;
            }
        }

        // Handle CV upload
        if ($request->hasFile('resume')) {
            if ($profile->resume_path) {
                Storage::disk('public')->delete($profile->resume_path);
            }
            $profileData['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }

        // Handle dokumen pendukung
        if ($request->hasFile('documents')) {
            $existingDocs = $profile->documents ?? [];
            foreach ($request->file('documents') as $doc) {
                $existingDocs[] = [
                    'name' => $doc->getClientOriginalName(),
                    'path' => $doc->store('documents', 'public'),
                ];
            }
            $profileData['documents'] = $existingDocs;
        }

        $profile->fill($profileData);
        $profile->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Hapus dokumen pendukung tertentu
     */
    public function deleteDocument(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return back()->with('error', 'Profil tidak ditemukan.');
        }

        $index = $request->input('index');
        $docs = $profile->documents ?? [];

        if (isset($docs[$index])) {
            Storage::disk('public')->delete($docs[$index]['path']);
            array_splice($docs, $index, 1);
            $profile->update(['documents' => $docs]);
        }

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Hapus CV
     */
    public function deleteResume()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if ($profile && $profile->resume_path) {
            Storage::disk('public')->delete($profile->resume_path);
            $profile->update(['resume_path' => null]);
        }

        return back()->with('success', 'CV berhasil dihapus.');
    }

    // =============================================
    //  PRIVATE HELPERS
    // =============================================

    /**
     * Bersihkan array education — buang entry yang kosong
     */
    private function cleanEducation(?array $education): ?array
    {
        if (empty($education)) return null;

        $cleaned = [];
        foreach ($education as $edu) {
            // Skip jika level dan institution kosong
            if (empty($edu['level']) && empty($edu['institution'])) continue;

            $cleaned[] = [
                'level'       => $edu['level'] ?? '',
                'institution' => $edu['institution'] ?? '',
                'major'       => $edu['major'] ?? '',
                'year_start'  => $edu['year_start'] ?? '',
                'year_end'    => $edu['year_end'] ?? '',
                'gpa'         => $edu['gpa'] ?? '',
            ];
        }

        return !empty($cleaned) ? $cleaned : null;
    }

    /**
     * Bersihkan array experience — buang entry kosong, handle "masih bekerja"
     */
    private function cleanExperience(?array $experience): ?array
    {
        if (empty($experience)) return null;

        $cleaned = [];
        foreach ($experience as $exp) {
            // Skip jika position dan company kosong
            if (empty($exp['position']) && empty($exp['company'])) continue;

            $isCurrent = !empty($exp['current']) && $exp['current'] == '1';

            $cleaned[] = [
                'position'    => $exp['position'] ?? '',
                'company'     => $exp['company'] ?? '',
                'year_start'  => $exp['year_start'] ?? '',
                'year_end'    => $isCurrent ? null : ($exp['year_end'] ?? ''),
                'current'     => $isCurrent ? true : false,
                'description' => $exp['description'] ?? '',
            ];
        }

        return !empty($cleaned) ? $cleaned : null;
    }
}