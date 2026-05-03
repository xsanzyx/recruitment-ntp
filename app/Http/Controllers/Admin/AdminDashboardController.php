<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobVacancy;
use App\Models\Application;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_user'     => User::count(),
            'total_hr_admin' => User::whereIn('role', ['hr', 'admin'])->count(),
            'total_kandidat' => User::whereIn('role', ['user', 'kandidat'])->count(),
            'lowongan_aktif' => JobVacancy::where('status', 'open')->count(),
        ];

        $distribusi = [
            'admin'    => User::where('role', 'admin')->count(),
            'hr'       => User::where('role', 'hr')->count(),
            'kandidat' => User::whereIn('role', ['user', 'kandidat'])->count(),
        ];

        $user_aktif  = User::where('status', 'active')->count();
        $user_pending = User::where('status', 'pending')->count();

        $user_terbaru = User::whereIn('role', ['user', 'kandidat'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('pages.admin.dashboard', compact(
            'stats',
            'distribusi',
            'user_aktif',
            'user_pending',
            'user_terbaru'
        ));
    }
}
