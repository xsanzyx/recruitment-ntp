@extends('layouts.main')

@section('content')

<section style="padding: 100px 0 80px;">
<div class="container" style="max-width: 720px;">

    <div class="fade-up mb-4">
        <small class="section-label"><i class="bi bi-person-gear me-2"></i>Profil Saya</small>
        <h1 class="hero-title mt-2">Edit Profil</h1>
        <p class="hero-subtitle">Lengkapi profilmu agar HR dapat mengenalmu lebih baik.</p>
    </div>

    @if(session('success'))
    <div class="fade-up mb-4" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);border-radius:12px;padding:14px 18px;color:#166534;">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
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

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Avatar --}}
        <div class="fade-up mb-4" style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
            <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:20px;">Foto Profil</h5>
            <div class="d-flex align-items-center gap-4">
                <div id="avatar-preview" style="width:80px;height:80px;border-radius:50%;overflow:hidden;border:2px solid rgba(0,40,112,0.15);flex-shrink:0;">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" id="avatar-img" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div id="avatar-placeholder" style="width:100%;height:100%;background:rgba(0,40,112,0.06);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill" style="font-size:36px;color:var(--primary-color);"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <label class="btn btn-secondary-custom px-3 py-2" style="border-radius:10px;font-size:13px;cursor:pointer;margin:0;">
                        <i class="bi bi-upload me-2"></i>Upload Foto
                        <input type="file" name="avatar" id="avatar-input" accept=".jpg,.jpeg,.png" style="display:none;">
                    </label>
                    <p style="font-size:12px;color:#94a3b8;margin:8px 0 0;">JPG atau PNG, maksimal 2MB</p>
                </div>
            </div>
        </div>

        {{-- Data Diri --}}
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
                <div class="col-12">
                    <label class="apply-label">Bio Singkat</label>
                    <textarea name="bio" class="apply-input" rows="4" maxlength="500"
                        placeholder="Ceritakan sedikit tentang dirimu...">{{ old('bio', $user->bio) }}</textarea>
                    <small class="text-muted" style="font-size:11px;" id="bio-count">{{ strlen($user->bio ?? '') }}/500</small>
                </div>
            </div>
        </div>

        {{-- Link --}}
        <div class="fade-up mb-4" style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
            <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:20px;">Link Profil</h5>
            <div class="row g-3">
                <div class="col-12">
                    <label class="apply-label"><i class="bi bi-briefcase me-2"></i>Portfolio URL</label>
                    <input type="url" name="portfolio_url" class="apply-input"
                        placeholder="https://portofolio.com/namakamu"
                        value="{{ old('portfolio_url', $user->portfolio_url) }}">
                </div>
                <div class="col-12">
                    <label class="apply-label"><i class="bi bi-linkedin me-2"></i>LinkedIn URL</label>
                    <input type="url" name="linkedin_url" class="apply-input"
                        placeholder="https://linkedin.com/in/namakamu"
                        value="{{ old('linkedin_url', $user->linkedin_url) }}">
                </div>
            </div>
        </div>

        <div class="fade-up d-flex justify-content-end gap-3">
            <a href="{{ route('home') }}" class="btn px-4 py-2"
               style="border-radius:10px;border:1px solid #e5e7eb;color:#64748b;">
                Batal
            </a>
            <button type="submit" class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;">
                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
            </button>
        </div>

    </form>
</div>
</section>

@include('components.footer')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/apply.css') }}">
@endpush

@push('scripts')
<script>
// Avatar preview
document.getElementById('avatar-input').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran foto maksimal 2MB.');
        this.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        const preview = document.getElementById('avatar-preview');
        preview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
    };
    reader.readAsDataURL(file);
});

// Bio counter
const bioEl    = document.querySelector('[name="bio"]');
const bioCount = document.getElementById('bio-count');
if (bioEl && bioCount) {
    bioEl.addEventListener('input', () => {
        bioCount.textContent = bioEl.value.length + '/500';
    });
}
</script>
@endpush