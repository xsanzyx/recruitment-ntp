@extends('layouts.admin')

@section('title', 'Tambah User Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tambah User Baru</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary-custom" style="padding:8px 16px; border-radius:8px; text-decoration:none; background:#e9edf1; color:#0d1b2e; font-weight:600;">
        Kembali
    </a>
</div>

<div class="card" style="background:#fff; border-radius:14px; padding:24px; box-shadow:0 2px 16px rgba(0,40,112,0.08);">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row" style="display:flex; flex-wrap:wrap; margin: -10px;">
            <div class="col-md-6" style="padding:10px; flex:0 0 50%; max-width:50%;">
                <label style="font-weight:600; font-size:13px; margin-bottom:6px; display:block;">Nama Depan</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required style="width:100%; padding:10px 14px; border:1px solid #c5cdd8; border-radius:8px;">
                @error('first_name') <small style="color:#e63946;">{{ $message }}</small> @enderror
            </div>
            
            <div class="col-md-6" style="padding:10px; flex:0 0 50%; max-width:50%;">
                <label style="font-weight:600; font-size:13px; margin-bottom:6px; display:block;">Nama Belakang</label>
                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" style="width:100%; padding:10px 14px; border:1px solid #c5cdd8; border-radius:8px;">
                @error('last_name') <small style="color:#e63946;">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-12" style="padding:10px; flex:0 0 100%; max-width:100%;">
                <label style="font-weight:600; font-size:13px; margin-bottom:6px; display:block;">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required style="width:100%; padding:10px 14px; border:1px solid #c5cdd8; border-radius:8px;">
                @error('email') <small style="color:#e63946;">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6" style="padding:10px; flex:0 0 50%; max-width:50%;">
                <label style="font-weight:600; font-size:13px; margin-bottom:6px; display:block;">Role</label>
                <select name="role" required style="width:100%; padding:10px 14px; border:1px solid #c5cdd8; border-radius:8px;">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Kandidat</option>
                    <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="col-md-6" style="padding:10px; flex:0 0 50%; max-width:50%;">
                <label style="font-weight:600; font-size:13px; margin-bottom:6px; display:block;">Status</label>
                <select name="status" required style="width:100%; padding:10px 14px; border:1px solid #c5cdd8; border-radius:8px;">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="nonactive" {{ old('status') == 'nonactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="col-md-6" style="padding:10px; flex:0 0 50%; max-width:50%;">
                <label style="font-weight:600; font-size:13px; margin-bottom:6px; display:block;">Password</label>
                <input type="password" name="password" class="form-control" required style="width:100%; padding:10px 14px; border:1px solid #c5cdd8; border-radius:8px;">
                @error('password') <small style="color:#e63946;">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6" style="padding:10px; flex:0 0 50%; max-width:50%;">
                <label style="font-weight:600; font-size:13px; margin-bottom:6px; display:block;">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required style="width:100%; padding:10px 14px; border:1px solid #c5cdd8; border-radius:8px;">
            </div>
        </div>

        <div style="margin-top:20px; text-align:right;">
            <button type="submit" style="background:#002870; color:#fff; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer;">Simpan User</button>
        </div>
    </form>
</div>
@endsection
