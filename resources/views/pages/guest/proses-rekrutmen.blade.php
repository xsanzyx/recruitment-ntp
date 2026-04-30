@extends('layouts.main')

@section('content')

<section style="padding: 100px 0 80px;">
    <div class="container">

        <div class="fade-up mb-5">
            <small class="section-label"><i class="bi bi-diagram-3 me-2"></i>Alur Seleksi</small>
            <h1 class="hero-title mt-2">Transparan, Cepat, dan <em>Manusiawi</em></h1>
            <p class="hero-subtitle">Proses rekrutmen yang jelas tanpa ribet dan mudah dipahami oleh semua kandidat.</p>
        </div>

            <div class="row g-5 align-items-start">

                {{-- Steps --}}
                <div class="col-lg-7">
                    <div class="process-item fade-up">
                        <span>01</span>
                        <div>
                            <strong>Kirim Lamaran</strong>
                            <p>Pilih posisi yang sesuai dan kirim CV serta portofolio melalui portal ini.</p>
                        </div>
                    </div>
                    <div class="process-item fade-up">
                        <span>02</span>
                        <div>
                            <strong>Screening Awal</strong>
                            <p>Tim HR akan meninjau kelengkapan dokumen dan kesesuaian profil dalam 5 hari kerja.</p>
                        </div>
                    </div>
                    <div class="process-item fade-up">
                        <span>03</span>
                        <div>
                            <strong>Pantau Status Lamaran</strong>
                            <p>Lihat perkembangan lamaranmu secara real-time melalui dashboard akun kamu.</p>
                        </div>
                    </div>
                    <div class="process-item fade-up">
                        <span>04</span>
                        <div>
                            <strong>Wawancara</strong>
                            <p>Sesi dengan HR dan tim teknis terkait. Bisa dilakukan secara online maupun tatap muka.</p>
                        </div>
                    </div>
                    <div class="process-item fade-up">
                        <span>05</span>
                        <div>
                            <strong>Keputusan Akhir</strong>
                            <p>Hasil seleksi akan dikirim melalui email dan notifikasi di portal dalam 3 hari setelah wawancara.</p>
                        </div>
                    </div>
                </div>

                {{-- Info Panel --}}
                <div class="col-lg-5 fade-up">
                    <div style="background:#f8faff;border-radius:16px;padding:28px;border:1px solid #e8edf5;position:sticky;top:100px;">
                        <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:20px;">Info Penting</h5>

                        <div class="d-flex gap-3 mb-4">
                            <div style="width:40px;height:40px;background:rgba(0,40,112,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-clock" style="color:var(--primary-color);"></i>
                            </div>
                            <div>
                                <strong style="font-size:14px;color:#111827;">Durasi Proses</strong>
                                <p style="font-size:13px;color:#64748b;margin:4px 0 0;">Rata-rata 2–3 minggu dari lamaran hingga keputusan akhir.</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <div style="width:40px;height:40px;background:rgba(0,40,112,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-bell" style="color:var(--primary-color);"></i>
                            </div>
                            <div>
                                <strong style="font-size:14px;color:#111827;">Notifikasi Real-Time</strong>
                                <p style="font-size:13px;color:#64748b;margin:4px 0 0;">Setiap perubahan status lamaran akan dikirim ke emailmu.</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <div style="width:40px;height:40px;background:rgba(0,40,112,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-shield-check" style="color:var(--primary-color);"></i>
                            </div>
                            <div>
                                <strong style="font-size:14px;color:#111827;">Data Terlindungi</strong>
                                <p style="font-size:13px;color:#64748b;margin:4px 0 0;">Informasi pribadimu hanya digunakan untuk keperluan rekrutmen.</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <div style="width:40px;height:40px;background:rgba(0,40,112,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-patch-check" style="color:var(--primary-color);"></i>
                            </div>
                            <div>
                                <strong style="font-size:14px;color:#111827;">Gratis & Transparan</strong>
                                <p style="font-size:13px;color:#64748b;margin:4px 0 0;">Tidak ada biaya pendaftaran. Proses seleksi sepenuhnya transparan.</p>
                            </div>
                        </div>

                        <a href="{{ route('lowongan') }}" class="btn btn-secondary-custom w-100 py-2" style="border-radius:10px;">
                            Lihat Lowongan Terbuka →
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

@include('components.footer')

@endsection