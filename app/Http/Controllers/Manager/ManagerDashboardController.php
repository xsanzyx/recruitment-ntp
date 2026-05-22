<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Support\Facades\Auth;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $department = $user->department;

        // Lowongan di departemen manager
        $vacancyIds = JobVacancy::where('department', $department)->pluck('id');

        $totalActiveVacancies = JobVacancy::where('department', $department)
            ->where('status', 'open')
            ->count();

        $totalApplicants = Application::whereIn('job_vacancy_id', $vacancyIds)->count();

        $statusCounts = Application::whereIn('job_vacancy_id', $vacancyIds)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $recentApplications = Application::with(['user.profile', 'jobVacancy'])
            ->whereIn('job_vacancy_id', $vacancyIds)
            ->latest('applied_at')
            ->take(5)
            ->get();

        $topVacancies = JobVacancy::where('department', $department)
            ->where('status', 'open')
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->take(4)
            ->get();

        return view('pages.manager.dashboard', compact(
            'department',
            'totalActiveVacancies',
            'totalApplicants',
            'statusCounts',
            'recentApplications',
            'topVacancies'
        ));
    }
}
