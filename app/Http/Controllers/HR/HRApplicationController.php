<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HRApplicationController extends Controller
{
    /**
     * Helper: Get vacancy IDs visible to the current user.
     * Admin sees all, HR sees only their own.
     */
    private function getVacancyIds()
    {
        $user = Auth::user();
        return $user->role === 'admin'
            ? JobVacancy::pluck('id')
            : JobVacancy::where('created_by', $user->id)->pluck('id');
    }

    /**
     * Daftar semua pelamar dengan filter & pagination.
     * Filter: status, department, education (multi-filter bisa dikombinasikan).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        $vacancyIds = $this->getVacancyIds();

        $applications = Application::with(['user.profile', 'jobVacancy'])
            ->whereIn('job_vacancy_id', $vacancyIds)
            ->when($request->status, fn($q, $v) => $q->where('status', $v))
            ->when($request->department, fn($q, $v) =>
                $q->whereHas('jobVacancy', fn($q) => $q->where('department', $v))
            )
            ->when($request->education, fn($q, $v) =>
                $q->whereHas('user.profile', fn($q) => $q->where('last_education', $v))
            )
            ->when($request->search, fn($q, $v) =>
                $q->whereHas('user', fn($q) =>
                    $q->where('first_name', 'like', "%{$v}%")
                      ->orWhere('last_name', 'like', "%{$v}%")
                      ->orWhere('email', 'like', "%{$v}%")
                )
            )
            ->latest('applied_at')
            ->paginate(10)
            ->withQueryString();

        // Ambil list department unik untuk dropdown filter
        $deptQuery = $isAdmin
            ? JobVacancy::query()
            : JobVacancy::where('created_by', $user->id);

        $departments = $deptQuery->distinct()->pluck('department');

        return view('pages.hr.applications.index', compact('applications', 'departments'));
    }

    /**
     * Detail pelamar: info pribadi, pendidikan, lamaran, resume.
     */
    public function show(string $id)
    {
        $vacancyIds = $this->getVacancyIds();

        $application = Application::with(['user.profile', 'jobVacancy', 'reviewer'])
            ->whereIn('job_vacancy_id', $vacancyIds)
            ->findOrFail($id);

        return view('pages.hr.applications.show', compact('application'));
    }

    /**
     * Update status kandidat oleh HR.
     * Status: pending → review → lolos / tidak_lolos
     */
    public function updateStatus(Request $request, string $id)
    {
        $vacancyIds = $this->getVacancyIds();

        $application = Application::whereIn('job_vacancy_id', $vacancyIds)
            ->findOrFail($id);

        $validated = $request->validate([
            'status'       => 'required|in:pending,review,lolos,tidak_lolos',
            'review_notes' => 'nullable|string|max:1000',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status tidak valid.',
        ]);

        $application->update([
            'status'       => $validated['status'],
            'review_notes' => $validated['review_notes'] ?? $application->review_notes,
            'reviewed_by'  => Auth::id(),
        ]);

        $statusLabel = match ($validated['status']) {
            'pending'     => 'Pending',
            'review'      => 'Sedang Direview',
            'lolos'       => 'Lolos',
            'tidak_lolos' => 'Tidak Lolos',
        };

        return redirect()
            ->back()
            ->with('success', "Status kandidat berhasil diubah menjadi \"{$statusLabel}\".");
    }

    /**
     * Bulk update status untuk banyak kandidat sekaligus.
     */
    public function bulkStatus(Request $request)
    {
        $validated = $request->validate([
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer',
            'status' => 'required|in:pending,review,lolos,tidak_lolos',
        ]);

        $vacancyIds = $this->getVacancyIds();

        $count = Application::whereIn('job_vacancy_id', $vacancyIds)
            ->whereIn('id', $validated['ids'])
            ->update([
                'status'      => $validated['status'],
                'reviewed_by' => Auth::id(),
            ]);

        $label = match($validated['status']) {
            'pending'     => 'Pending',
            'review'      => 'In Review',
            'lolos'       => 'Lolos',
            'tidak_lolos' => 'Tidak Lolos',
        };

        return redirect()
            ->back()
            ->with('success', "{$count} kandidat berhasil diubah menjadi \"{$label}\".");
    }

    /**
     * Download resume atau dokumen kandidat.
     */
    public function downloadFile(string $id, string $type, ?int $docIndex = null)
    {
        $vacancyIds = $this->getVacancyIds();

        $application = Application::whereIn('job_vacancy_id', $vacancyIds)
            ->findOrFail($id);

        if ($type === 'resume' && $application->resume_path) {
            $path = $application->resume_path;
            $fileName = 'Resume_' . str_replace(' ', '_', $application->user->full_name) . '.pdf';
        } elseif ($type === 'document' && $docIndex !== null && !empty($application->documents[$docIndex])) {
            $doc = $application->documents[$docIndex];
            $path = $doc['path'];
            $fileName = $doc['name'];
        } else {
            abort(404, 'File tidak ditemukan.');
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        return Storage::disk('public')->download($path, $fileName);
    }
}
