<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($builder) use ($q) {
                $builder->where('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'semua') {
            $query->where('role', $request->role);
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $total  = User::count();
        $users  = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('pages.admin.users.index', compact('users', 'total'));
    }

    public function create()
    {
        return view('pages.admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'role'       => 'required|in:admin,hr,kandidat',
        ], [
            'first_name.required'  => 'Nama depan wajib diisi.',
            'email.required'       => 'Email wajib diisi.',
            'email.unique'         => 'Email ini sudah terdaftar.',
            'password.required'    => 'Password wajib diisi.',
            'password.min'         => 'Password minimal 8 karakter.',
            'password.confirmed'   => 'Konfirmasi password tidak sesuai.',
        ]);

        // User yang dibuat Admin langsung aktif (tidak perlu OTP)
        User::create([
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name ?? '',
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => $request->role,
            'status'            => 'active',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('pages.admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'       => 'required|in:admin,hr,kandidat',
            'status'     => 'required|in:active,pending,nonactive',
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name ?? '',
            'email'      => $request->email,
            'role'       => $request->role,
            'status'     => $request->status,
        ];

        // Jika admin mengaktifkan user, pastikan email terverifikasi
        if ($request->status === 'active' && !$user->email_verified_at) {
            $data['email_verified_at'] = now();
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', "Data {$user->first_name} berhasil diperbarui (Status: " . ($user->status == 'active' ? 'Aktif' : 'Nonaktif') . ").");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
