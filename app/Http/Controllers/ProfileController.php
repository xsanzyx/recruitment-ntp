<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('pages.guest.profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'bio'           => 'nullable|string|max:500',
            'portfolio_url' => 'nullable|url|max:255',
            'linkedin_url'  => 'nullable|url|max:255',
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'last_name.required'  => 'Nama belakang wajib diisi.',
            'avatar.image'        => 'Avatar harus berupa gambar.',
            'avatar.mimes'        => 'Avatar harus berformat JPG atau PNG.',
            'avatar.max'          => 'Ukuran avatar maksimal 2MB.',
            'portfolio_url.url'   => 'URL portfolio tidak valid.',
            'linkedin_url.url'    => 'URL LinkedIn tidak valid.',
        ]);

        $data = [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'bio'           => $request->bio,
            'portfolio_url' => $request->portfolio_url,
            'linkedin_url'  => $request->linkedin_url,
        ];

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}