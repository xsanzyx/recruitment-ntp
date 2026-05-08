<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CandidateMiddleware
{
    /**
     * Proteksi route Kandidat — mencegah HR / Admin mengakses fitur pelamar.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Jika HR mencoba mengakses halaman kandidat
        if ($user->role === 'hr') {
            return redirect()->route('hr.dashboard')->with('error', 'Akun HR tidak dapat melamar pekerjaan atau mengakses profil kandidat.');
        }

        // Jika Admin mencoba mengakses halaman kandidat
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akun Admin tidak dapat melamar pekerjaan atau mengakses profil kandidat.');
        }

        return $next($request);
    }
}
