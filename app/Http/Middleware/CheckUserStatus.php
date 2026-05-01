<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status !== 'active') {
            $status = Auth::user()->status;
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $status === 'pending' 
                ? 'Akun Anda memerlukan verifikasi.' 
                : 'Akun Anda telah dinonaktifkan oleh administrator.';

            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        return $next($request);
    }
}
