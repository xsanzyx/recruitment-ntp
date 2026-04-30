<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Halaman utama — tampilkan 3 lowongan open terbaru.
     */
    public function home()
    {
        $vacancies = JobVacancy::open()
            ->where('deadline', '>=', now())
            ->latest()
            ->take(3)
            ->get();

        return view('pages.guest.home', compact('vacancies'));
    }

    /**
     * Halaman daftar lowongan — semua lowongan open yang belum expired.
     */
    public function lowongan()
    {
        $vacancies = JobVacancy::open()
            ->where('deadline', '>=', now())
            ->latest()
            ->get();

        // Ambil daftar departemen & divisi unik dari lowongan yang aktif
        $departments = JobVacancy::open()
            ->where('deadline', '>=', now())
            ->distinct()->pluck('department')->sort()->values();

        $divisions = JobVacancy::open()
            ->where('deadline', '>=', now())
            ->distinct()->pluck('division')->sort()->values();

        return view('pages.guest.lowongan', compact('vacancies', 'departments', 'divisions'));
    }
}
