@extends('layouts.main')

@section('content')

<section style="padding: 100px 0 80px;">
    <div class="container">

        <div class="fade-up mb-5">
            <small class="section-label"><i class="bi bi-building me-2"></i>Tentang Kami</small>
            <h1 class="hero-title mt-2">PT Nusantara Turbin dan Propulsi</h1>
            <p class="hero-subtitle">Pemimpin dalam pemeliharaan dan perbaikan mesin turbin di Asia Tenggara sejak 1986.</p>
        </div>

        {{-- Profil + Stats --}}
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6 fade-up">
                <h4 style="font-weight:700;color:var(--primary-color);margin-bottom:16px;">Profil Perusahaan</h4>
                <p style="color:#64748b;line-height:1.8;">
                    Sebagai pemimpin dalam pemeliharaan dan perbaikan mesin turbin di Asia Tenggara,
                    kami berkomitmen pada standar kualitas tertinggi. Kami percaya bahwa keunggulan operasional
                    dimulai dari sumber daya manusia yang kompeten dan berintegritas.
                </p>
                <p style="color:#64748b;line-height:1.8;font-size:14px;">
                    Berlokasi strategis di Bandung, kami melayani berbagai klien domestik dan internasional,
                    mendukung ketahanan energi dan mobilitas udara bangsa Indonesia.
                </p>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#64748b;">
                        <i class="bi bi-geo-alt-fill" style="color:var(--primary-color);"></i>
                        Jl. Pajajaran No. 154, Bandung
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#64748b;">
                        <i class="bi bi-calendar-check" style="color:var(--primary-color);"></i>
                        Berdiri sejak 1986
                    </div>
                </div>
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

        {{-- Nilai Perusahaan --}}
        <div class="fade-up mb-3">
            <h4 style="font-weight:700;color:var(--primary-color);">Nilai Perusahaan</h4>
        </div>
        <div class="row g-3 mb-5">
            @foreach([
                ['bi-award','Integritas','Kami menjunjung tinggi kejujuran dan transparansi dalam setiap aspek pekerjaan.'],
                ['bi-lightbulb','Inovasi','Mendorong kreativitas dan solusi baru untuk tantangan industri yang terus berkembang.'],
                ['bi-people','Kolaborasi','Membangun tim yang solid dengan budaya saling mendukung dan menghargai.'],
                ['bi-graph-up-arrow','Keunggulan','Berkomitmen pada standar kualitas tertinggi di setiap produk dan layanan.'],
            ] as [$icon, $title, $desc])
            <div class="col-md-6 col-lg-3">
                <div style="background:#f8faff;border-radius:14px;padding:24px;border:1px solid #e8edf5;height:100%;">
                    <div style="width:44px;height:44px;background:rgba(0,40,112,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                        <i class="bi {{ $icon }}" style="font-size:20px;color:var(--primary-color);"></i>
                    </div>
                    <strong style="color:var(--primary-color);font-size:15px;">{{ $title }}</strong>
                    <p style="font-size:13px;color:#64748b;margin-top:8px;line-height:1.6;">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="cta-box-big fade-up">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h4 class="fw-bold mb-2">Bergabunglah bersama kami</h4>
                    <p class="text-light mb-0">Jadilah bagian dari tim yang membangun masa depan industri turbin Indonesia.</p>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('lowongan') }}" class="btn btn-light me-2">Lihat Lowongan →</a>
                    <a href="{{ route('kontak') }}" class="btn btn-outline-light">Hubungi Kami →</a>
                </div>
            </div>
        </div>

    </div>
</section>

@include('components.footer')

@endsection