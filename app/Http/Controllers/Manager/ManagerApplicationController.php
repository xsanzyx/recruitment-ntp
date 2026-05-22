<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManagerApplicationController extends Controller
{
    /**
     * Get vacancy IDs for the manager's department.
     */
    private function getVacancyIds()
    {
        $department = Auth::user()->department;
        return JobVacancy::where('department', $department)->pluck('id');
    }

    /**
     * Daftar pelamar di departemen manager (read-only).
     */
    public function index(Request $request)
    {
        $department = Auth::user()->department;
        $vacancyIds = $this->getVacancyIds();

        $applications = Application::with(['user.profile', 'jobVacancy'])
            ->whereIn('job_vacancy_id', $vacancyIds)
            ->when($request->status, fn($q, $v) => $q->where('status', $v))
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

        return view('pages.manager.applications.index', compact('applications', 'department'));
    }

    /**
     * Detail pelamar (read-only, tanpa form update status).
     */
    public function show(string $id)
    {
        $vacancyIds = $this->getVacancyIds();

        $application = Application::with(['user.profile', 'jobVacancy', 'reviewer'])
            ->whereIn('job_vacancy_id', $vacancyIds)
            ->findOrFail($id);

        return view('pages.manager.applications.show', compact('application'));
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
