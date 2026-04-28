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
                <div class="search-bar">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Cari posisi pekerjaan...">
                    <button class="search-btn">Cari</button>
                </div>
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

{{-- ================= QUICK STATS ================= --}}
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4 fade-up">
                <div class="quick-stat">
                    <div class="quick-stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <span class="quick-stat-number">300+</span>
                    <span class="quick-stat-label">Karyawan</span>
                </div>
            </div>
            <div class="col-md-4 fade-up">
                <div class="quick-stat">
                    <div class="quick-stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <span class="quick-stat-number">40 Tahun</span>
                    <span class="quick-stat-label">Pengalaman</span>
                </div>
            </div>
            <div class="col-md-4 fade-up">
                <div class="quick-stat">
                    <div class="quick-stat-icon">
                        <i class="bi bi-emoji-smile-fill"></i>
                    </div>
                    <span class="quick-stat-number">180+</span>
                    <span class="quick-stat-label">Pelanggan Puas</span>
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
                <div class="search-bar" style="max-width: 320px; padding: 4px 4px 4px 12px;">
                    <i class="bi bi-search" style="font-size: 14px;"></i>
                    <input type="text" placeholder="Filter pekerjaan..." style="font-size: 13px;">
                </div>
            </div>
            <a href="#" class="view-all">
                Lihat semua lowongan <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="d-flex flex-column gap-3">
            {{-- Expanded Card --}}
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
                        <button class="btn btn-secondary-custom px-4 py-2" style="border-radius: 10px; font-size: 14px;">
                            Lamar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            {{-- Collapsed Card 1 --}}
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
                        <button class="btn btn-secondary-custom px-4 py-2" style="border-radius: 10px; font-size: 14px;">
                            Lamar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            {{-- Collapsed Card 2 --}}
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
                        <button class="btn btn-secondary-custom px-4 py-2" style="border-radius: 10px; font-size: 14px;">
                            Lamar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= PROSES REKRUTMEN ================= --}}
<section id="proses" class="process-section">
    <div class="container">
        <h2 class="fade-up">Transparan, Cepat, dan Manusiawi</h2>
        
        <div class="process-timeline fade-up">
            <div class="process-step">
                <div class="process-number primary">1</div>
                <h4>Kirim Lamaran</h4>
                <p>Unggah CV dan portofolio terbaikmu.</p>
            </div>
            <div class="process-step">
                <div class="process-number primary">2</div>
                <h4>Screening Awal</h4>
                <p>Tim HR meninjau kualifikasi berkas.</p>
            </div>
            <div class="process-step">
                <div class="process-number primary">3</div>
                <h4>Pantau Status</h4>
                <p>Cek perkembangan lamaran secara real-time.</p>
            </div>
            <div class="process-step">
                <div class="process-number primary">4</div>
                <h4>Wawancara</h4>
                <p>Diskusi mendalam bersama tim user.</p>
            </div>
            <div class="process-step">
                <div class="process-number accent">5</div>
                <h4>Keputusan Akhir</h4>
                <p>Selamat bergabung di keluarga besar kami!</p>
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
<section class="cta-section">
    <div class="container">
        <div class="cta-box-big text-center fade-up" style="position: relative; z-index: 1;">
            <h2 style="position: relative; z-index: 2;">Siap menjadi bagian dari perjalanan kami?</h2>
            <p style="position: relative; z-index: 2;">
                Jangan lewatkan kesempatan untuk berkontribusi bagi kemajuan industri Indonesia. 
                Lamar sekarang atau hubungi tim rekrutmen kami.
            </p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3" style="position: relative; z-index: 2;">
                <button class="cta-btn-primary">Lihat Semua Lowongan</button>
                <button class="cta-btn-secondary">Hubungi HR</button>
            </div>
        </div>
    </div>
</section>

{{-- ================= FOOTER ================= --}}
<footer id="kontak" class="site-footer">
    <div class="container">
        <div class="row g-5">
            {{-- Brand & Social --}}
            <div class="col-lg-4">
                <div class="footer-brand">NTP Careers</div>
                <p class="footer-desc">
                    Platform rekrutmen resmi PT Nusantara Turbin dan Propulsi. Membangun karir profesional 
                    dan berkontribusi untuk kemajuan industri turbin nasional.
                </p>
                <div class="footer-social">
                    <a href="https://www.instagram.com/ntpindonesia" target="_blank" rel="noopener">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://youtube.com/@ntpindonesia2335" target="_blank" rel="noopener">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="mailto:info@ntp.id">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
            </div>

            {{-- Informasi --}}
            <div class="col-lg-4">
                <h5 class="footer-heading">Informasi</h5>
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms of Service</a>
                <a href="#" class="footer-link">FAQ</a>
                <a href="#" class="footer-link">Careers</a>
            </div>

            {{-- Kontak --}}
            <div class="col-lg-4">
                <h5 class="footer-heading">Kontak Kami</h5>
                <div class="footer-contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <span>hr@ntp.co.id</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <span>+62 22 605 5555</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Jl. Pajajaran No. 154, Bandung 40174</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 NTP Careers — PT Nusantara Turbin dan Propulsi. All rights reserved.</p>
        </div>
    </div>
</footer>

@endsection