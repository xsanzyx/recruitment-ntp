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
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        // Admin melihat SEMUA lowongan, HR hanya miliknya sendiri
        $vacancyQuery = $isAdmin
            ? JobVacancy::query()
            : JobVacancy::where('created_by', $user->id);

        // Total lowongan aktif
        $totalActiveVacancies = (clone $vacancyQuery)
            ->where('status', 'open')
            ->count();

        // Total semua lowongan
        $totalVacancies = (clone $vacancyQuery)->count();

        // ID semua lowongan (untuk filter lamaran)
        $vacancyIds = (clone $vacancyQuery)->pluck('id');

        // Total pelamar hari ini
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
        $topVacancies = (clone $vacancyQuery)
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
