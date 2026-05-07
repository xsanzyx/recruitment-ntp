@extends('layouts.main')

@section('content')

<section style="padding: 100px 0 80px;">
<div class="container" style="max-width: 780px;">

    <div class="fade-up mb-4">
        <small class="section-label"><i class="bi bi-send me-2"></i>Konfirmasi Lamaran</small>
        <h1 class="hero-title mt-2">Lamar — {{ $vacancy->title }}</h1>
        <p class="hero-subtitle">{{ $vacancy->division }} · {{ $vacancy->department }}</p>
    </div>

    {{-- ═══ ELIGIBILITY CHECK ═══ --}}
    @if(!$eligibility['eligible'])
    <div class="fade-up mb-4" style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:16px;padding:28px;">
        <div class="d-flex align-items-start gap-3">
            <i class="bi bi-shield-x" style="font-size:28px;color:#dc2626;flex-shrink:0;"></i>
            <div>
                <h5 style="font-weight:700;color:#dc2626;margin-bottom:8px;">Kamu Tidak Memenuhi Syarat</h5>
                <p style="font-size:14px;color:#7f1d1d;margin-bottom:12px;">Maaf, profilmu tidak sesuai dengan kriteria lowongan ini:</p>
                <ul style="margin:0;padding-left:20px;color:#991b1b;font-size:14px;">
                    @foreach($eligibility['reasons'] as $reason)
                    <li class="mb-1">{{ $reason }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('lowongan') }}" class="btn mt-3 px-4 py-2" style="border-radius:10px;border:1px solid rgba(239,68,68,0.3);color:#dc2626;font-size:13px;font-weight:600;">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Lowongan
                </a>
            </div>
        </div>
    </div>
    @else

    {{-- ═══ RINGKASAN PROFIL ═══ --}}
    <div class="fade-up mb-4" style="background:#fff;border-radius:16px;padding:28px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 style="font-weight:700;color:var(--primary-color);margin:0;">Ringkasan Profilmu</h5>
            <a href="{{ route('profile') }}" style="font-size:13px;color:var(--primary-color);font-weight:600;text-decoration:none;">
                <i class="bi bi-pencil me-1"></i>Edit Profil
            </a>
        </div>

        <div class="row g-3" style="font-size:14px;">
            <div class="col-md-6">
                <div style="color:#64748b;">Nama</div>
                <div style="font-weight:600;color:#0f172a;">{{ auth()->user()->full_name }}</div>
            </div>
            <div class="col-md-6">
                <div style="color:#64748b;">Email</div>
                <div style="font-weight:600;color:#0f172a;">{{ auth()->user()->email }}</div>
            </div>
            <div class="col-md-6">
                <div style="color:#64748b;">Telepon</div>
                <div style="font-weight:600;color:#0f172a;">{{ $profile->phone }}</div>
            </div>
            <div class="col-md-6">
                <div style="color:#64748b;">Jenis Kelamin / Umur</div>
                <div style="font-weight:600;color:#0f172a;">{{ $profile->gender }} · {{ $profile->getAge() }} tahun</div>
            </div>
            <div class="col-md-6">
                <div style="color:#64748b;">Pendidikan Terakhir</div>
                <div style="font-weight:600;color:#0f172a;">{{ $profile->getHighestEducationLevel() ?? '-' }}</div>
            </div>
            <div class="col-md-6">
                <div style="color:#64748b;">IPK / Nilai Akhir</div>
                <div style="font-weight:600;color:#0f172a;">{{ $profile->gpa ?? '-' }}</div>
            </div>

            {{-- Link Profil --}}
            @if(auth()->user()->portfolio_url || auth()->user()->linkedin_url)
            <div class="col-12" style="border-top:1px solid #e8edf5;padding-top:12px;margin-top:4px;">
                <div style="color:#64748b;margin-bottom:6px;">Link Profil</div>
                <div class="d-flex flex-wrap gap-3">
                    @if(auth()->user()->portfolio_url)
                    <a href="{{ auth()->user()->portfolio_url }}" target="_blank" style="font-size:13px;color:var(--primary-color);font-weight:600;text-decoration:none;">
                        <i class="bi bi-briefcase me-1"></i>Portfolio
                    </a>
                    @endif
                    @if(auth()->user()->linkedin_url)
                    <a href="{{ auth()->user()->linkedin_url }}" target="_blank" style="font-size:13px;color:var(--primary-color);font-weight:600;text-decoration:none;">
                        <i class="bi bi-linkedin me-1"></i>LinkedIn
                    </a>
                    @endif
                </div>
            </div>
            @endif

            {{-- Pengalaman Kerja --}}
            @if(!empty($profile->experience))
            <div class="col-12" style="border-top:1px solid #e8edf5;padding-top:12px;margin-top:4px;">
                <div style="color:#64748b;margin-bottom:8px;">Pengalaman Kerja</div>
                @foreach($profile->experience as $exp)
                <div style="margin-bottom:8px;">
                    <div style="font-weight:600;color:#0f172a;font-size:13px;">{{ $exp['position'] ?? '-' }} — {{ $exp['company'] ?? '-' }}</div>
                    <div style="font-size:12px;color:#94a3b8;">
                        {{ $exp['year_start'] ?? '' }} - {{ !empty($exp['current']) ? 'Sekarang' : ($exp['year_end'] ?? '') }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="col-12" style="border-top:1px solid #e8edf5;padding-top:12px;margin-top:4px;">
                <div style="color:#64748b;">CV</div>
                <div style="font-weight:600;color:#0f172a;">
                    <i class="bi bi-file-earmark-pdf me-1" style="color:var(--primary-color);"></i>
                    CV telah diupload
                    <a href="{{ Storage::url($profile->resume_path) }}" target="_blank" style="font-size:12px;color:var(--primary-color);margin-left:6px;">Lihat</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ SYARAT LOWONGAN ═══ --}}
    <div class="fade-up mb-4" style="background:#f0fdf4;border-radius:16px;padding:20px 28px;border:1px solid #bbf7d0;">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-check-circle-fill" style="color:#16a34a;font-size:20px;"></i>
            <strong style="color:#166534;font-size:15px;">Kamu memenuhi semua syarat!</strong>
        </div>
        <p style="font-size:13px;color:#15803d;margin:0;">Profilmu sesuai dengan kriteria lowongan ini. Silakan kirim lamaranmu.</p>
    </div>

    {{-- ═══ FORM LAMARAN ═══ --}}
    <form action="{{ route('apply.store', $vacancy->id) }}" method="POST">
        @csrf

        <div class="fade-up mb-4" style="background:#fff;border-radius:16px;padding:28px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
            <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:16px;">Pesan untuk HR (opsional)</h5>
            <textarea name="summary" class="apply-input" rows="4" maxlength="500"
                placeholder="Ceritakan motivasimu melamar posisi ini...">{{ old('summary') }}</textarea>
            <small class="text-muted" style="font-size:11px;">Maksimal 500 karakter</small>
        </div>

        <div class="fade-up d-flex justify-content-between">
            <a href="{{ route('lowongan') }}" class="btn px-4 py-2" style="border-radius:10px;border:1px solid #e5e7eb;color:#64748b;">
                <i class="bi bi-arrow-left me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;">
                <i class="bi bi-send me-2"></i>Kirim Lamaran
            </button>
        </div>
    </form>
    @endif

</div>
</section>

@include('components.footer')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pages/apply.css') }}">
@endpush