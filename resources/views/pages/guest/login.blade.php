@extends('layouts.main')

@section('content')

<section class="login-section">
    {{-- ================= LEFT ================= --}}
    <div class="login-left">

        {{-- MIDDLE: form (otomatis center karena justify-content: center) --}}
        <div class="login-box px-4 py-4">

            <a href="{{ route('home') }}" class="company-link mb-3 d-flex align-items-center gap-3 text-decoration-none">
                <div class="pb-3">
                    <h6 class="fw-bold primary-text mb-0">PT Nusantara Turbin dan Propulsi</h6>
                    <small class="text-muted" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">
                        Careers Portal
                    </small>
                </div>
            </a>
            <h2 class="fw-bold mb-1">Selamat datang kembali</h2>
            <p class="text-muted mb-3" style="font-size:14px;">
                Masuk untuk melanjutkan perjalanan karirmu bersama kami.
            </p>

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="mb-2">
                    <label for="email" class="auth-label mb-1">Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope"></i>
                        <input type="email" id="email" name="email"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="auth-label mb-1">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="password" name="password"
                            placeholder="••••••••" required>
                    </div>
                    @error('password')
                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-secondary-custom w-100 login-btn">
                    Masuk
                </button>
            </form>

            <div class="d-flex align-items-center my-3 gap-2">
                <hr class="flex-grow-1 m-0">
                <small class="text-muted px-2">ATAU</small>
                <hr class="flex-grow-1 m-0">
            </div>

            <p class="text-center text-muted mb-2" style="font-size:13px;">
                Belum punya akun?
                <a href="{{ route('register') }}" class="primary-text fw-bold text-decoration-none">
                    Daftar Sekarang
                </a>
            </p>

        </div>

        {{-- BOTTOM: footer --}}
        <small class="text-muted login-footer">
            © 2026 PT Nusantara Turbin dan Propulsi
        </small>

    </div>


    {{-- ================= RIGHT ================= --}}
    <div class="login-right">

        <div class="login-right-bg"></div>
        <div class="login-right-accent"></div>

        <div class="company-box">

            <div class="company-badge">
                <i class="bi bi-patch-check-fill"></i>
                <span>Perusahaan Terpercaya</span>
            </div>

            <h3 class="fw-bold text-white mb-3">
                Bergabunglah dengan tim yang membangun masa depan industri Indonesia
            </h3>

            <p class="company-desc">
                PT Nusantara Turbin dan Propulsi telah berdiri sejak 1986, melayani industri energi dan manufaktur nasional dengan standar kualitas internasional.
            </p>

            <div class="stat-grid">
                <div class="stat-box">
                    <h5>1986</h5>
                    <small>Tahun Berdiri</small>
                </div>
                <div class="stat-box">
                    <h5>300+</h5>
                    <small>Karyawan</small>
                </div>
                <div class="stat-box">
                    <h5>2100+</h5>
                    <small>Mesin Dikirim</small>
                </div>
                <div class="stat-box">
                    <h5>180+</h5>
                    <small>Klien Puas</small>
                </div>
            </div>

            <div class="company-divider"></div>

            <div class="company-features">
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <div class="feature-text">
                        <strong>Lingkungan Kerja Profesional</strong>
                        <span>Budaya kolaboratif, inklusif, dan berorientasi pada hasil nyata.</span>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <div class="feature-text">
                        <strong>Jenjang Karier Jelas</strong>
                        <span>Program pengembangan SDM terstruktur di setiap level jabatan.</span>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-geo-alt"></i></div>
                    <div class="feature-text">
                        <strong>Berlokasi di Bandung</strong>
                        <span>Jl. Pajajaran 154 — jantung industri Jawa Barat.</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>

{{-- ================= OTP MODAL ================= --}}
@include('pages.guest.verify-email')

@if(session('show_otp'))
<div id="otp-auto-trigger"
    data-email="{{ session('masked_email') }}"
    style="display:none;">
</div>
@endif

@endsection