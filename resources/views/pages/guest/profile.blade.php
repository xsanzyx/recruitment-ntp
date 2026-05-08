@extends('layouts.main')

@section('content')

<section style="padding: 100px 0 80px;">
<div class="container" style="max-width: 780px;">

    <div class="fade-up mb-4">
        <small class="section-label"><i class="bi bi-person-gear me-2"></i>Profil Saya</small>
        <h1 class="hero-title mt-2">Profil & Lamaran</h1>
        <p class="hero-subtitle">Kelola profilmu dan pantau status lamaranmu.</p>
    </div>

    @if(session('success'))
    <div class="fade-up mb-4" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);border-radius:12px;padding:14px 18px;color:#166534;">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    @if(session('warning'))
    <div class="fade-up mb-4" style="background:rgba(248,184,48,0.12);border:1px solid rgba(248,184,48,0.3);border-radius:12px;padding:14px 18px;color:#92620a;">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
        @if(session('missing_fields'))
        <ul style="margin:8px 0 0;font-size:13px;">
            @foreach(session('missing_fields') as $f)
            <li>{{ $f }}</li>
            @endforeach
        </ul>
        @endif
    </div>
    @endif

    @if($errors->any())
    <div class="fade-up mb-4" style="background:rgba(186,26,26,0.08);border:1px solid rgba(186,26,26,0.2);border-radius:12px;padding:14px 18px;color:#ba1a1a;">
        <ul style="margin:0;padding-left:20px;font-size:14px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ═══ AVATAR & LINK PROFIL ═══ --}}
        <div class="row g-4 fade-up mb-4">
            <div class="col-lg-5">
                <div style="background:#fff;border-radius:16px;padding:28px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;">
                    <h5 style="font-weight:700;color:var(--primary-color);margin:0;align-self:flex-start;">Foto Profil</h5>
                    <div id="avatar-preview" style="width:120px;height:120px;border-radius:50%;overflow:hidden;border:3px solid rgba(0,40,112,0.12);">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div style="width:100%;height:100%;background:rgba(0,40,112,0.06);display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-person-fill" style="font-size:52px;color:var(--primary-color);"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-center">
                        <label class="btn btn-secondary-custom px-3 py-2" style="border-radius:10px;font-size:13px;cursor:pointer;margin:0;">
                            <i class="bi bi-upload me-2"></i>{{ $user->avatar ? 'Ganti Foto' : 'Upload Foto' }}
                            <input type="file" name="avatar" id="avatar-input" accept=".jpg,.jpeg,.png" style="display:none;">
                        </label>
                        <p style="font-size:12px;color:#94a3b8;margin:8px 0 0;">JPG atau PNG, maks 2MB</p>
                    </div>
                    <input type="hidden" name="avatar_cropped" id="avatar-cropped">
                </div>
            </div>
            <div class="col-lg-7">
                <div style="background:#fff;border-radius:16px;padding:28px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);height:100%;">
                    <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:20px;">Link Profil</h5>
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <label class="apply-label"><i class="bi bi-briefcase me-2"></i>Portfolio URL</label>
                            <input type="url" name="portfolio_url" class="apply-input" placeholder="https://portofolio.com/namakamu" value="{{ old('portfolio_url', $user->portfolio_url) }}">
                        </div>
                        <div>
                            <label class="apply-label"><i class="bi bi-linkedin me-2"></i>LinkedIn URL</label>
                            <input type="url" name="linkedin_url" class="apply-input" placeholder="https://linkedin.com/in/namakamu" value="{{ old('linkedin_url', $user->linkedin_url) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ DATA DIRI ═══ --}}
        <div class="fade-up mb-4" style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
            <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:20px;">Data Diri</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="apply-label">Nama Depan *</label>
                    <input type="text" name="first_name" class="apply-input" value="{{ old('first_name', $user->first_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="apply-label">Nama Belakang *</label>
                    <input type="text" name="last_name" class="apply-input" value="{{ old('last_name', $user->last_name) }}" required>
                </div>
                <div class="col-12">
                    <label class="apply-label">Email</label>
                    <input type="email" class="apply-input" value="{{ $user->email }}" disabled>
                    <small class="text-muted" style="font-size:11px;">Email tidak dapat diubah.</small>
                </div>
                <div class="col-md-6">
                    <label class="apply-label">No. Telepon / WhatsApp *</label>
                    <input type="text" name="phone" class="apply-input" placeholder="+62 812 3456 7890" value="{{ old('phone', $profile->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="apply-label">Tanggal Lahir *</label>
                    <input type="date" name="birth_date" class="apply-input" value="{{ old('birth_date', $profile->birth_date?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="apply-label">Jenis Kelamin *</label>
                    <select name="gender" class="apply-input">
                        <option value="">Pilih</option>
                        <option value="Laki-laki" {{ old('gender', $profile->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $profile->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="apply-label">Domisili / Kota *</label>
                    <input type="text" name="address" class="apply-input" placeholder="Kota / Kabupaten" value="{{ old('address', $profile->address) }}">
                </div>
                <div class="col-12">
                    <label class="apply-label">Bio Singkat</label>
                    <textarea name="bio" class="apply-input" rows="3" maxlength="500" placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->bio) }}</textarea>
                    <small class="text-muted" style="font-size:11px;" id="bio-count">{{ strlen($user->bio ?? '') }}/500</small>
                </div>
            </div>
        </div>

        {{-- ═══ PENDIDIKAN ═══ --}}
        @include('pages.guest.profile-partials.education')

        {{-- ═══ PENGALAMAN KERJA ═══ --}}
        @include('pages.guest.profile-partials.experience')

        {{-- ═══ CV & DOKUMEN ═══ --}}
        @include('pages.guest.profile-partials.documents')

        {{-- ═══ LAMARAN SAYA ═══ --}}
        @include('pages.guest.profile-partials.applications')

        {{-- ═══ TOMBOL SIMPAN ═══ --}}
        <div class="fade-up d-flex justify-content-end gap-3">
            <a href="{{ url()->previous() }}" class="btn px-4 py-2" style="border-radius:10px;border:1px solid #e5e7eb;color:#64748b;">Batal</a>
            @php $hasErrors = $errors->any(); @endphp
            <button id="btn-save-profile" type="submit" 
                    class="btn {{ $hasErrors ? 'btn-secondary-custom' : '' }} px-4 py-2" 
                    style="border-radius:10px; transition:all 0.3s; {{ $hasErrors ? '' : 'border:1px solid #e5e7eb; color:#64748b; background:transparent;' }}" 
                    {{ $hasErrors ? '' : 'disabled' }}>
                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>

{{-- Modal Crop (di luar form agar position:fixed bekerja sempurna) --}}
<div id="crop-modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.7);z-index:9999;justify-content:center;align-items:center;">
    <div style="background:#fff;border-radius:16px;padding:24px;max-width:480px;width:90%;max-height:90vh;overflow:auto;">
        <h6 style="font-weight:700;color:var(--primary-color);margin-bottom:16px;">Posisikan Foto</h6>
        <div style="width:100%;max-height:360px;overflow:hidden;border-radius:10px;background:#f1f5f9;">
            <img id="crop-image" style="max-width:100%;">
        </div>
        <p style="font-size:12px;color:#94a3b8;margin:12px 0;">Drag untuk memindahkan, scroll untuk zoom.</p>
        <div class="d-flex gap-2 justify-content-end">
            <button type="button" id="crop-cancel" class="btn px-4 py-2" style="border-radius:10px;border:1px solid #e5e7eb;color:#64748b;font-size:14px;">Batal</button>
            <button type="button" id="crop-confirm" class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;font-size:14px;">
                <i class="bi bi-check-lg me-2"></i>Gunakan Foto
            </button>
        </div>
    </div>
</div>

</section>

@include('components.footer')
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/apply.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
@endpush