<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRApplicationController extends Controller
{
    /**
     * Daftar semua pelamar dengan filter & pagination.
     * Filter: status, department, education (multi-filter bisa dikombinasikan).
     */
    public function index(Request $request)
    {
        // Hanya tampilkan lamaran untuk lowongan milik HR ini
        $vacancyIds = JobVacancy::where('created_by', Auth::id())->pluck('id');

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
        $departments = JobVacancy::where('created_by', Auth::id())
            ->distinct()
            ->pluck('department');

        return view('pages.hr.applications.index', compact('applications', 'departments'));
    }

    /**
     * Detail pelamar: info pribadi, pendidikan, lamaran, resume.
     */
    public function show(string $id)
    {
        $vacancyIds = JobVacancy::where('created_by', Auth::id())->pluck('id');

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
        $vacancyIds = JobVacancy::where('created_by', Auth::id())->pluck('id');

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

        $vacancyIds = JobVacancy::where('created_by', Auth::id())->pluck('id');

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
}
