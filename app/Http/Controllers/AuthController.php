<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // =============================================
    //  REGISTER
    // =============================================
    public function showRegister()
    {
        return view('pages.guest.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'terms'      => 'accepted',
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'last_name.required'  => 'Nama belakang wajib diisi.',
            'email.required'      => 'Email wajib diisi.',
            'email.unique'        => 'Email ini sudah terdaftar.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal 6 karakter.',
            'terms.accepted'      => 'Kamu harus menyetujui syarat & ketentuan.',
        ]);

        // Buat user, belum verified
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        // Generate & kirim OTP
        $this->sendOtp($user);

        // Simpan user id di session untuk proses verifikasi
        session(['pending_user_id' => $user->id]);

        // Kembalikan response — JS akan buka modal OTP
        if ($request->expectsJson()) {
            return response()->json([
                'success'      => true,
                'masked_email' => $this->maskEmail($user->email),
            ]);
        }

        return back()->with('show_otp', true)->with('masked_email', $this->maskEmail($user->email));
    }


    // =============================================
    //  VERIFY OTP
    // =============================================
    public function verifyOtp(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $userId = session('pending_user_id');
        $user   = $userId ? User::find($userId) : null;

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Sesi tidak valid. Silakan daftar ulang.'], 422);
        }

        if (!$user->isOtpValid($request->code)) {
            return response()->json(['success' => false, 'message' => 'Kode salah atau sudah kadaluarsa.'], 422);
        }

        // Tandai email terverifikasi & bersihkan OTP
        $user->update([
            'email_verified_at' => now(),
            'otp_code'          => null,
            'otp_expires_at'    => null,
        ]);

        session()->forget('pending_user_id');

        return response()->json(['success' => true, 'redirect' => route('login')]);
    }


    // =============================================
    //  RESEND OTP
    // =============================================
    public function resendOtp(Request $request)
    {
        $userId = session('pending_user_id');
        $user   = $userId ? User::find($userId) : null;

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Sesi tidak valid.'], 422);
        }

        $this->sendOtp($user);

        return response()->json(['success' => true]);
    }


    // =============================================
    //  LOGIN
    // =============================================
    public function showLogin()
    {
        return view('pages.guest.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        $user = Auth::user();

        // Cek apakah email sudah diverifikasi
        if (!$user->email_verified_at) {
            Auth::logout();
            $this->sendOtp($user);
            session(['pending_user_id' => $user->id]);
            return back()->with('show_otp', true)->with('masked_email', $this->maskEmail($user->email));
        }

        $request->session()->regenerate();

        // Redirect berdasarkan role user
        return match ($user->role) {
            'hr', 'admin' => redirect()->intended(route('hr.dashboard')),
            default       => redirect()->intended(route('home')),
        };
    }


    // =============================================
    //  LOGOUT
    // =============================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }


    // =============================================
    //  HELPERS (private)
    // =============================================

    private function sendOtp(User $user): void
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($user, $otp));
    }

    private function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email);
        $masked = substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 4));
        return $masked . '@' . $domain;
    }
}