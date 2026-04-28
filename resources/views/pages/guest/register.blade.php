@extends('layouts.main')

@section('content')

<section class="login-section">

    {{-- ================= LEFT ================= --}}
    <div class="login-left">

        <a href="{{ route('home') }}" class="back-link mb-2">← Kembali ke beranda</a>

        <div class="login-box">

            <div class="mb-2 d-flex align-items-center gap-3">
                <div class="job-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <h6 class="fw-bold primary-text mb-0">PT Nusantara Turbin dan Propulsi</h6>
                    <small class="text-muted" style="font-size:11px;letter-spacing:1px;text-transform:uppercase;">Careers Portal</small>
                </div>
            </div>

            <h2 class="fw-bold mb-1">Buat akun baru</h2>
            <p class="text-muted mb-2">Daftar dan mulai lamar pekerjaan impianmu.</p>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label for="first_name" class="auth-label">Nama Depan</label>
                        <input type="text" id="first_name" name="first_name"
                            class="form-input-custom" placeholder="contoh. Fajar"
                            value="{{ old('first_name') }}" required autocomplete="given-name">
                        @error('first_name')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="last_name" class="auth-label">Nama Belakang</label>
                        <input type="text" id="last_name" name="last_name"
                            class="form-input-custom" placeholder="contoh. Zaini Syam"
                            value="{{ old('last_name') }}" required autocomplete="family-name">
                        @error('last_name')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mb-2">
                    <label for="email" class="auth-label">Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope"></i>
                        <input type="email" id="email" name="email"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}" required autocomplete="email">
                    </div>
                    @error('email')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="password" class="auth-label">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="password" name="password"
                            placeholder="minimal 6 karakter" required autocomplete="new-password">
                    </div>
                    @error('password')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-2 d-flex align-items-start gap-2">
                    <input type="checkbox" id="terms" name="terms"
                        class="form-check-input mt-1" required
                        style="min-width:18px;height:18px;">
                    <label for="terms" class="form-check-label text-muted" style="font-size:13px;">
                        Saya setuju dengan
                        <a href="#" class="primary-text fw-semibold text-decoration-none">Syarat & Ketentuan</a>
                        dan
                        <a href="#" class="primary-text fw-semibold text-decoration-none">Kebijakan Privasi</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-secondary-custom w-100 py-2">
                    Daftar Sekarang
                </button>

            </form>

            <div class="d-flex align-items-center my-2 gap-2">
                <hr class="flex-grow-1 m-0">
                <small class="text-muted px-2">ATAU</small>
                <hr class="flex-grow-1 m-0">
            </div>

            <p class="text-center text-muted mb-0" style="font-size:14px;">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="primary-text fw-bold text-decoration-none">Masuk di Sini</a>
            </p>

            <small class="text-muted login-footer">© 2026 PT Nusantara Turbin dan Propulsi</small>

        </div>

    </div>


    {{-- ================= RIGHT ================= --}}
    <div class="login-right">

        <div class="login-right-bg"></div>
        <div class="login-right-accent"></div>

        <div class="company-box">

            <div class="company-badge">
                <i class="bi bi-rocket-takeoff-fill"></i>
                <span>Mulai Kariermu</span>
            </div>

            <h3 class="fw-bold text-white mb-3">
                Satu langkah menuju karier impianmu di industri teknologi nasional
            </h3>

            <p class="company-desc">
                Dengan mendaftar, kamu bisa memantau status lamaran secara real-time, mendapat notifikasi lowongan baru, dan terhubung langsung dengan tim HR kami.
            </p>

            <div class="stat-grid">
                <div class="stat-box">
                    <h5>3+</h5>
                    <small>Posisi Terbuka</small>
                </div>
                <div class="stat-box">
                    <h5>5 Hari</h5>
                    <small>Respons HR</small>
                </div>
                <div class="stat-box">
                    <h5>100%</h5>
                    <small>Transparan</small>
                </div>
                <div class="stat-box">
                    <h5>Gratis</h5>
                    <small>Daftar & Lamar</small>
                </div>
            </div>

            <div class="company-divider"></div>

            <div class="company-features">
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-bell"></i></div>
                    <div class="feature-text">
                        <strong>Notifikasi Real-Time</strong>
                        <span>Update status lamaran langsung dikirim ke email kamu.</span>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-file-earmark-check"></i></div>
                    <div class="feature-text">
                        <strong>Pantau Status Lamaran</strong>
                        <span>Lihat setiap tahap seleksi secara transparan dan real-time.</span>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-lock-fill"></i></div>
                    <div class="feature-text">
                        <strong>Data Aman & Terlindungi</strong>
                        <span>Informasi pribadimu dijaga dengan standar keamanan tinggi.</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>

{{-- ================= OTP MODAL ================= --}}
@include('pages.guest.verify-email')
{{--
    Tambahkan snippet ini di register.blade.php
    tepat sebelum @endsection, SETELAH @include modal

    Fungsi: trigger modal otomatis kalau Laravel
    redirect back() with('show_otp', true)
--}}

@if(session('show_otp'))
<div id="otp-auto-trigger"
     data-email="{{ session('masked_email') }}"
     style="display:none;">
</div>
@endif
@endsection