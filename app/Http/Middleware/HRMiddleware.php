<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HRMiddleware
{
    /**
     * Proteksi route HR — hanya user dengan role 'hr' atau 'admin' yang boleh akses.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Belum login → redirect ke halaman login
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Role bukan HR dan bukan Admin → tolak akses
        if (!in_array($user->role, ['hr', 'admin'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
