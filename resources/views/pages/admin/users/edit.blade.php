@extends('layouts.admin')

@section('title', 'Edit User')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-panel.css') }}">
@endpush

@section('content')

{{-- ═══ PAGE HEADER ═══ --}}
<div class="page-header">
    <div class="page-header-left">
        <div class="dash-label"><i class="bi bi-pencil-square me-1"></i>Admin Panel</div>
        <div class="title">Edit User</div>
        <div class="dash-desc">Ubah data, role, atau status akun user ini.</div>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-cancel" style="margin-top:8px;">
        ← Kembali
    </a>
</div>

{{-- ═══ FORM CARD ═══ --}}
<div class="admin-form-wrap">

    @if($errors->any())
    <div style="background:rgba(186,26,26,0.08);border:1px solid rgba(186,26,26,0.2);border-radius:12px;padding:14px 18px;color:#ba1a1a;margin-bottom:20px;">
        <ul style="margin:0;padding-left:20px;font-size:14px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="admin-form-card">

        {{-- User Preview --}}
        <div style="display:flex;align-items:center;gap:14px;padding:16px;background:#f8faff;border-radius:12px;border:1px solid var(--gray);margin-bottom:24px;">
            @if($user->avatar)
                <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->first_name }}"
                     style="width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid var(--gray);flex-shrink:0;">
            @else
                <div style="width:48px;height:48px;border-radius:50%;background:var(--primary-pale);color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;flex-shrink:0;">
                    {{ $user->initial }}
                </div>
            @endif
            <div>
                <div style="font-weight:700;font-size:15px;color:var(--text);">{{ $user->first_name }} {{ $user->last_name }}</div>
                <div style="font-size:13px;color:var(--text-muted);">{{ $user->email }}</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Bergabung {{ $user->created_at->format('d M Y') }}</div>
            </div>
        </div>

        {{-- Role Picker --}}
        <div style="margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid var(--gray);">
            <label class="admin-form-label">Role <span style="color:var(--danger);">*</span></label>
            <div class="role-picker">
                <div class="role-option">
                    <input type="radio" name="role" value="admin" id="roleAdmin" form="editForm" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}>
                    <label for="roleAdmin">
                        <div class="role-icon ri-admin"><i class="bi bi-shield-fill" style="font-size:15px;"></i></div>
                        Admin
                    </label>
                </div>
                <div class="role-option">
                    <input type="radio" name="role" value="hr" id="roleHR" form="editForm" {{ old('role', $user->role) == 'hr' ? 'checked' : '' }}>
                    <label for="roleHR">
                        <div class="role-icon ri-hr"><i class="bi bi-person-badge-fill" style="font-size:15px;"></i></div>
                        HR
                    </label>
                </div>
                <div class="role-option">
                    <input type="radio" name="role" value="user" id="roleUser" form="editForm" {{ old('role', $user->role) == 'user' ? 'checked' : '' }}>
                    <label for="roleUser">
                        <div class="role-icon ri-user"><i class="bi bi-person-fill" style="font-size:15px;"></i></div>
                        Kandidat
                    </label>
                </div>
            </div>
        </div>

        <form id="editForm" action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="form-row" style="margin-bottom:16px;">
                <div>
                    <label class="admin-form-label">Nama Depan <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="first_name" class="admin-form-input" value="{{ old('first_name', $user->first_name) }}" required>
                    @error('first_name')<span class="admin-form-error">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="admin-form-label">Nama Belakang</label>
                    <input type="text" name="last_name" class="admin-form-input" value="{{ old('last_name', $user->last_name) }}">
                </div>
            </div>

            {{-- Email --}}
            <div style="margin-bottom:16px;">
                <label class="admin-form-label">Email <span style="color:var(--danger);">*</span></label>
                <input type="email" name="email" class="admin-form-input" value="{{ old('email', $user->email) }}" required>
                @error('email')<span class="admin-form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Status --}}
            <div style="margin-bottom:16px;">
                <label class="admin-form-label">Status <span style="color:var(--danger);">*</span></label>
                <select name="status" class="admin-form-input">
                    <option value="active"    {{ old('status', $user->status) == 'active'    ? 'selected' : '' }}>Aktif</option>
                    <option value="pending"   {{ old('status', $user->status) == 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="nonactive" {{ old('status', $user->status) == 'nonactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <span class="admin-form-hint">Mengubah status ke <strong>Aktif</strong> akan otomatis memverifikasi email user.</span>
            </div>

            {{-- Password --}}
            <div class="form-row" style="margin-bottom:8px;">
                <div>
                    <label class="admin-form-label">Password Baru</label>
                    <input type="password" name="password" id="editPassword" class="admin-form-input" placeholder="Kosongkan jika tidak diubah">
                    @error('password')<span class="admin-form-error">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="admin-form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="editPasswordConfirm" class="admin-form-input" placeholder="Ulangi password baru">
                </div>
            </div>
            <div id="passwordError" style="display:none;font-size:12px;color:var(--danger);margin-bottom:16px;"></div>

            {{-- Actions --}}
            <div class="form-actions" style="padding-top:20px;border-top:1px solid var(--gray);">
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('editForm').addEventListener('submit', function(e) {
    const pw  = document.getElementById('editPassword').value;
    const pwc = document.getElementById('editPasswordConfirm').value;
    const err = document.getElementById('passwordError');
    err.style.display = 'none';

    if (pw && pw.length < 8) {
        e.preventDefault();
        err.innerText = 'Password minimal 8 karakter.';
        err.style.display = 'block';
        return;
    }
    if (pw && pw !== pwc) {
        e.preventDefault();
        err.innerText = 'Konfirmasi password tidak sesuai.';
        err.style.display = 'block';
    }
});
</script>
@endpush