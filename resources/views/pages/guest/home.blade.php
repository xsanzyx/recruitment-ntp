@extends('layouts.main')

@section('content')

{{-- ================= HERO ================= --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-up">
                <h1 class="hero-title">Gabung Bersama Kami</h1>
                <p class="hero-subtitle">
                    Membangun masa depan industri kedirgantaraan Indonesia bersama talenta-talenta terbaik. 
                    Temukan karir impianmu di PT Nusantara Turbin dan Propulsi.
                </p>
                <form action="{{ route('lowongan') }}" method="GET" class="search-bar">
                    <i class="bi bi-search"></i>
                    <input type="text" name="q" placeholder="Cari posisi pekerjaan...">
                    <button type="submit" class="search-btn">Cari</button>
                </form>
            </div>
            <div class="col-lg-6 fade-up">
                <div class="hero-image-wrapper">
                    <video class="hero-video" autoplay muted loop playsinline>
                        <source src="{{ asset('video/hero.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= LOWONGAN ================= --}}
<section id="lowongan" class="jobs-section">
    <div class="container">
        <div class="jobs-header fade-up">
            <div>
                <h2>Rekomendasi Lowongan</h2>
            </div>
            <a href="{{ route('lowongan') }}" class="view-all">
                Lihat semua lowongan <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="d-flex flex-column gap-3">

            <div class="job-card expanded fade-up">
                <div class="job-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="job-icon primary-bg">
                            <i class="bi bi-code-slash"></i>
                        </div>
                        <div>
                            <strong style="font-size: 16px; color: var(--primary-color);">Software Engineer</strong><br>
                            <small style="color: var(--on-surface-variant);">Division: Information Technology</small>
                        </div>
                    </div>
                    <small class="toggle-text" style="color: var(--primary-color); cursor: pointer;">
                        <i class="bi bi-chevron-up"></i>
                    </small>
                </div>
                <div class="job-detail show">
                    <div class="job-detail-inner">
                        <div class="row g-4 mb-4">
                            <div class="col-md-7">
                                <h6 style="font-weight: 600; color: var(--primary-color); margin-bottom: 12px;">Kualifikasi:</h6>
                                <ul style="color: var(--on-surface-variant); font-size: 14px; padding-left: 20px;">
                                    <li class="mb-1">Pendidikan S1 Teknik Informatika atau setara.</li>
                                    <li class="mb-1">Pengalaman minimal 2 tahun dalam pengembangan aplikasi.</li>
                                    <li class="mb-1">Menguasai bahasa pemrograman Java, Python, atau Go.</li>
                                    <li class="mb-1">Memahami konsep Microservices dan RESTful API.</li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="job-info-box">
                                    <div class="job-info-row">
                                        <span class="job-info-label">Divisi</span>
                                        <span class="job-info-value">Information Technology</span>
                                    </div>
                                    <div class="job-info-row" style="border-top: 1px solid var(--outline-variant); margin-top: 8px; padding-top: 8px;">
                                        <span class="job-info-label">Tipe</span>
                                        <span class="job-info-value">Full-Time</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @auth
                            <button class="btn btn-secondary-custom px-4 py-2" style="border-radius: 10px; font-size: 14px;">Lamar Sekarang</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary-custom px-4 py-2" style="border-radius: 10px; font-size: 14px;">Login untuk Melamar</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="job-card fade-up">
                <div class="job-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="job-icon light-bg">
                            <i class="bi bi-palette-fill"></i>
                        </div>
                        <div>
                            <strong style="font-size: 16px; color: var(--primary-color);">UI/UX Designer</strong><br>
                            <small style="color: var(--on-surface-variant);">Division: Design & User Experience</small>
                        </div>
                    </div>
                    <small class="toggle-text" style="color: var(--outline); cursor: pointer;">
                        <i class="bi bi-chevron-down"></i>
                    </small>
                </div>
                <div class="job-detail">
                    <div class="job-detail-inner">
                        <div class="row g-4 mb-4">
                            <div class="col-md-7">
                                <h6 style="font-weight: 600; color: var(--primary-color); margin-bottom: 12px;">Kualifikasi:</h6>
                                <ul style="color: var(--on-surface-variant); font-size: 14px; padding-left: 20px;">
                                    <li class="mb-1">Pendidikan S1 Desain Komunikasi Visual atau setara.</li>
                                    <li class="mb-1">Menguasai Figma, Adobe XD, atau Sketch.</li>
                                    <li class="mb-1">Pemahaman design system dan design thinking.</li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="job-info-box">
                                    <div class="job-info-row">
                                        <span class="job-info-label">Divisi</span>
                                        <span class="job-info-value">Design & User Experience</span>
                                    </div>
                                    <div class="job-info-row" style="border-top: 1px solid var(--outline-variant); margin-top: 8px; padding-top: 8px;">
                                        <span class="job-info-label">Tipe</span>
                                        <span class="job-info-value">Full-Time</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @auth
                            <button class="btn btn-secondary-custom px-4 py-2" style="border-radius: 10px; font-size: 14px;">Lamar Sekarang</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary-custom px-4 py-2" style="border-radius: 10px; font-size: 14px;">Login untuk Melamar</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="job-card fade-up">
                <div class="job-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="job-icon light-bg">
                            <i class="bi bi-megaphone-fill"></i>
                        </div>
                        <div>
                            <strong style="font-size: 16px; color: var(--primary-color);">Marketing Executive</strong><br>
                            <small style="color: var(--on-surface-variant);">Division: Business Development</small>
                        </div>
                    </div>
                    <small class="toggle-text" style="color: var(--outline); cursor: pointer;">
                        <i class="bi bi-chevron-down"></i>
                    </small>
                </div>
                <div class="job-detail">
                    <div class="job-detail-inner">
                        <div class="row g-4 mb-4">
                            <div class="col-md-7">
                                <h6 style="font-weight: 600; color: var(--primary-color); margin-bottom: 12px;">Kualifikasi:</h6>
                                <ul style="color: var(--on-surface-variant); font-size: 14px; padding-left: 20px;">
                                    <li class="mb-1">Pendidikan S1 Marketing / Manajemen Bisnis.</li>
                                    <li class="mb-1">Pengalaman minimal 3 tahun di bidang pemasaran B2B.</li>
                                    <li class="mb-1">Kemampuan komunikasi dan negosiasi yang kuat.</li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="job-info-box">
                                    <div class="job-info-row">
                                        <span class="job-info-label">Divisi</span>
                                        <span class="job-info-value">Business Development</span>
                                    </div>
                                    <div class="job-info-row" style="border-top: 1px solid var(--outline-variant); margin-top: 8px; padding-top: 8px;">
                                        <span class="job-info-label">Tipe</span>
                                        <span class="job-info-value">Full-Time</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @auth
                            <button class="btn btn-secondary-custom px-4 py-2" style="border-radius: 10px; font-size: 14px;">Lamar Sekarang</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary-custom px-4 py-2" style="border-radius: 10px; font-size: 14px;">Login untuk Melamar</a>
                        @endauth
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ================= PROSES REKRUTMEN ================= --}}
<section class="container py-5">
    <div class="row align-items-start g-5">
        <div class="col-md-5 fade-up">
            <small class="section-label">Proses Rekrutmen</small>
            <h2 class="fw-bold primary-text mt-2">
                Transparan, Cepat, dan <em>Manusiawi</em>
            </h2>
            <p class="text-muted mt-3">
                Proses rekrutmen yang jelas tanpa ribet dan mudah dipahami oleh semua kandidat.
            </p>
        </div>
        <div class="col-md-7">
            <div class="process-item fade-up">
                <span>01</span>
                <div>
                    <strong>Kirim Lamaran</strong>
                    <p>Pilih posisi yang sesuai dan kirim CV serta portofolio.</p>
                </div>
            </div>
            <div class="process-item fade-up">
                <span>02</span>
                <div>
                    <strong>Screening Awal</strong>
                    <p>Tim HR akan meninjau dalam 5 hari kerja.</p>
                </div>
            </div>
            <div class="process-item fade-up">
                <span>03</span>
                <div>
                    <strong>Pantau Status Lamaran</strong>
                    <p>Lihat perkembangan lamaran secara real-time.</p>
                </div>
            </div>
            <div class="process-item fade-up">
                <span>04</span>
                <div>
                    <strong>Wawancara</strong>
                    <p>Sesi dengan HR dan tim teknis terkait.</p>
                </div>
            </div>
            <div class="process-item fade-up">
                <span>05</span>
                <div>
                    <strong>Keputusan Akhir</strong>
                    <p>Hasil seleksi akan dikirim melalui email.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= TENTANG KAMI ================= --}}
<section id="tentang" class="company-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-up">
                <span class="section-label">Profil Perusahaan</span>
                <h2>PT Nusantara Turbin dan Propulsi</h2>
                <p>
                    Sebagai pemimpin dalam pemeliharaan dan perbaikan mesin turbin di Asia Tenggara, 
                    kami berkomitmen pada standar kualitas tertinggi. Kami percaya bahwa keunggulan operasional 
                    dimulai dari sumber daya manusia yang kompeten dan berintegritas.
                </p>
                <p style="font-size: 14px;">
                    Berlokasi strategis di Bandung, kami melayani berbagai klien domestik dan internasional, 
                    mendukung ketahanan energi dan mobilitas udara bangsa.
                </p>
            </div>
            <div class="col-lg-6 fade-up">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stat-box">
                            <div class="stat-value">1986</div>
                            <div class="stat-label">Tahun Berdiri</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-box">
                            <div class="stat-value">300+</div>
                            <div class="stat-label">Karyawan</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-box">
                            <div class="stat-value">2100+</div>
                            <div class="stat-label">Mesin Dikirim</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-box">
                            <div class="stat-value">180+</div>
                            <div class="stat-label">Pelanggan Puas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= CTA ================= --}}
<section class="container py-5">
    <div class="cta-box-big fade-up">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3 class="fw-bold">Siap menjadi bagian dari perjalanan kami?</h3>
                <p class="text-light">
                    Kirim lamaranmu hari ini dan bangun sesuatu yang berarti bersama-sama.
                </p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('lowongan') }}" class="btn btn-light me-2">Lihat Semua Lowongan →</a>
                <a href="{{ route('kontak') }}" class="btn btn-outline-light">Hubungi HR →</a>
            </div>
        </div>
    </div>
</section>

@include('components.footer')

@endsection