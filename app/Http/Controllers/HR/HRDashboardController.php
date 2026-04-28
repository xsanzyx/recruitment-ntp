<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRDashboardController extends Controller
{
    public function index()
    {
        $hrId = Auth::id();

        // Total lowongan aktif milik HR ini
        $totalActiveVacancies = JobVacancy::where('created_by', $hrId)
            ->where('status', 'open')
            ->count();

        // Total semua lowongan milik HR ini
        $totalVacancies = JobVacancy::where('created_by', $hrId)->count();

        // ID semua lowongan milik HR ini (untuk filter lamaran)
        $vacancyIds = JobVacancy::where('created_by', $hrId)->pluck('id');

        // Total pelamar hari ini (di lowongan milik HR ini)
        $totalApplicantsToday = Application::whereIn('job_vacancy_id', $vacancyIds)
            ->whereDate('applied_at', today())
            ->count();

        // Total pelamar per status
        $statusCounts = [
            'pending'     => Application::whereIn('job_vacancy_id', $vacancyIds)->where('status', 'pending')->count(),
            'review'      => Application::whereIn('job_vacancy_id', $vacancyIds)->where('status', 'review')->count(),
            'lolos'       => Application::whereIn('job_vacancy_id', $vacancyIds)->where('status', 'lolos')->count(),
            'tidak_lolos' => Application::whereIn('job_vacancy_id', $vacancyIds)->where('status', 'tidak_lolos')->count(),
        ];

        // Total semua pelamar
        $totalApplicants = array_sum($statusCounts);

        // 4 lamaran terbaru
        $recentApplications = Application::with(['user', 'jobVacancy'])
            ->whereIn('job_vacancy_id', $vacancyIds)
            ->latest('applied_at')
            ->take(4)
            ->get();

        // 4 lowongan paling diminati
        $topVacancies = JobVacancy::where('created_by', $hrId)
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->take(4)
            ->get();

        return view('pages.hr.dashboard', compact(
            'totalActiveVacancies',
            'totalVacancies',
            'totalApplicantsToday',
            'totalApplicants',
            'statusCounts',
            'recentApplications',
            'topVacancies'
        ));
    }
}
