@extends('layouts.admin')

@section('title', 'Tambah User Baru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-panel.css') }}">
@endpush

@section('content')

{{-- ═══ PAGE HEADER ═══ --}}
<div class="page-header">
    <div class="page-header-left">
        <div class="dash-label"><i class="bi bi-person-plus me-1"></i>Admin Panel</div>
        <div class="title">Tambah User Baru</div>
        <div class="dash-desc">Buat akun user baru dengan role dan akses yang sesuai.</div>
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

        {{-- Role Picker --}}
        <div style="margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid var(--gray);">
            <label class="admin-form-label">Role <span style="color:var(--danger);">*</span></label>
            <div class="role-picker">
                <div class="role-option">
                    <input type="radio" name="role" value="admin" id="roleAdmin" form="createForm" {{ old('role') == 'admin' ? 'checked' : '' }}>
                    <label for="roleAdmin">
                        <div class="role-icon ri-admin"><i class="bi bi-shield-fill" style="font-size:15px;"></i></div>
                        Admin
                    </label>
                </div>
                <div class="role-option">
                    <input type="radio" name="role" value="hr" id="roleHR" form="createForm" {{ old('role', 'hr') == 'hr' ? 'checked' : '' }}>
                    <label for="roleHR">
                        <div class="role-icon ri-hr"><i class="bi bi-person-badge-fill" style="font-size:15px;"></i></div>
                        HR
                    </label>
                </div>
                <div class="role-option">
                    <input type="radio" name="role" value="user" id="roleUser" form="createForm" {{ old('role') == 'user' ? 'checked' : '' }}>
                    <label for="roleUser">
                        <div class="role-icon ri-user"><i class="bi bi-person-fill" style="font-size:15px;"></i></div>
                        Kandidat
                    </label>
                </div>
            </div>
        </div>

        <form id="createForm" action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            {{-- Nama --}}
            <div class="form-row" style="margin-bottom:16px;">
                <div>
                    <label class="admin-form-label">Nama Depan <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="first_name" class="admin-form-input" value="{{ old('first_name') }}" required placeholder="Nama depan">
                    @error('first_name')<span class="admin-form-error">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="admin-form-label">Nama Belakang</label>
                    <input type="text" name="last_name" class="admin-form-input" value="{{ old('last_name') }}" placeholder="Nama belakang">
                </div>
            </div>

            {{-- Email --}}
            <div style="margin-bottom:16px;">
                <label class="admin-form-label">Email <span style="color:var(--danger);">*</span></label>
                <input type="email" name="email" class="admin-form-input" value="{{ old('email') }}" required placeholder="email@contoh.com">
                @error('email')<span class="admin-form-error">{{ $message }}</span>@enderror
            </div>

            {{-- Password --}}
            <div class="form-row" style="margin-bottom:8px;">
                <div>
                    <label class="admin-form-label">Password <span style="color:var(--danger);">*</span></label>
                    <input type="password" name="password" id="createPassword" class="admin-form-input" required placeholder="Min. 8 karakter">
                    @error('password')<span class="admin-form-error">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="admin-form-label">Konfirmasi Password <span style="color:var(--danger);">*</span></label>
                    <input type="password" name="password_confirmation" id="createPasswordConfirm" class="admin-form-input" required placeholder="Ulangi password">
                </div>
            </div>
            <div id="passwordError" style="display:none;font-size:12px;color:var(--danger);margin-bottom:16px;"></div>

            <span class="admin-form-hint" style="margin-bottom:24px;display:block;">
                <i class="bi bi-info-circle me-1"></i>Status user yang dibuat Admin akan otomatis <strong>Aktif</strong>.
            </span>

            {{-- Actions --}}
            <div class="form-actions" style="padding-top:20px;border-top:1px solid var(--gray);">
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-lg"></i> Simpan User
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('createForm').addEventListener('submit', function(e) {
    const pw  = document.getElementById('createPassword').value;
    const pwc = document.getElementById('createPasswordConfirm').value;
    const err = document.getElementById('passwordError');
    err.style.display = 'none';

    if (pw.length < 8) {
        e.preventDefault();
        err.innerText = 'Password minimal 8 karakter.';
        err.style.display = 'block';
        return;
    }
    if (pw !== pwc) {
        e.preventDefault();
        err.innerText = 'Konfirmasi password tidak sesuai.';
        err.style.display = 'block';
    }
});
</script>
@endpush