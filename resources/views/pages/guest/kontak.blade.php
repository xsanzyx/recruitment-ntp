@extends('layouts.main')

@section('content')

<section style="padding: 100px 0 80px;">
    <div class="container">

        <div class="fade-up mb-5">
            <small class="section-label"><i class="bi bi-envelope me-2"></i>Hubungi Kami</small>
            <h1 class="hero-title mt-2">Ada yang ingin kamu tanyakan?</h1>
            <p class="hero-subtitle">Tim HR kami siap membantu menjawab pertanyaan seputar rekrutmen dan lowongan.</p>
        </div>

<div class="row g-5 align-items-stretch">
            {{-- Info Kontak --}}
            <div class="col-lg-5 fade-up">
                <div style="display:flex;flex-direction:column;height:100%;">

                    <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:24px;">Informasi Kontak</h5>

                    <div class="d-flex flex-column gap-3">
                        <div style="display:flex;align-items:flex-start;gap:14px;padding:16px;background:#f8faff;border-radius:12px;border:1px solid #e8edf5;">
                            <div style="width:40px;height:40px;background:rgba(0,40,112,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-envelope-fill" style="color:var(--primary-color);"></i>
                            </div>
                            <div>
                                <strong style="font-size:13px;color:var(--primary-color);">Email HR</strong>
                                <p style="margin:4px 0 0;font-size:14px;color:#374151;">hr@ntp.co.id</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:14px;padding:16px;background:#f8faff;border-radius:12px;border:1px solid #e8edf5;">
                            <div style="width:40px;height:40px;background:rgba(0,40,112,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-telephone-fill" style="color:var(--primary-color);"></i>
                            </div>
                            <div>
                                <strong style="font-size:13px;color:var(--primary-color);">Telepon</strong>
                                <p style="margin:4px 0 0;font-size:14px;color:#374151;">+62 22 605 5555</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:14px;padding:16px;background:#f8faff;border-radius:12px;border:1px solid #e8edf5;">
                            <div style="width:40px;height:40px;background:rgba(0,40,112,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-geo-alt-fill" style="color:var(--primary-color);"></i>
                            </div>
                            <div>
                                <strong style="font-size:13px;color:var(--primary-color);">Alamat</strong>
                                <p style="margin:4px 0 0;font-size:14px;color:#374151;">Jl. Pajajaran No. 154, Bandung 40174</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:14px;padding:16px;background:#f8faff;border-radius:12px;border:1px solid #e8edf5;">
                            <div style="width:40px;height:40px;background:rgba(0,40,112,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-clock" style="color:var(--primary-color);"></i>
                            </div>
                            <div>
                                <strong style="font-size:13px;color:var(--primary-color);">Jam Kerja</strong>
                                <p style="margin:4px 0 0;font-size:14px;color:#374151;">Senin–Jumat, 08.00–17.00 WIB</p>
                            </div>
                        </div>
                    </div>

                    {{-- Social nempel di bawah --}}
                    <div class="mt-auto pt-4">
                        <h6 style="font-weight:700;color:var(--primary-color);margin-bottom:12px;">Ikuti Kami</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.instagram.com/ntpindonesia" target="_blank" rel="noopener"
                            style="width:40px;height:40px;background:rgba(0,40,112,0.08);display:flex;align-items:center;justify-content:center;border-radius:10px;color:var(--primary-color);text-decoration:none;transition:0.2s;"
                            onmouseover="this.style.background='var(--primary-color)';this.style.color='#fff'"
                            onmouseout="this.style.background='rgba(0,40,112,0.08)';this.style.color='var(--primary-color)'">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://youtube.com/@ntpindonesia2335" target="_blank" rel="noopener"
                            style="width:40px;height:40px;background:rgba(0,40,112,0.08);display:flex;align-items:center;justify-content:center;border-radius:10px;color:var(--primary-color);text-decoration:none;transition:0.2s;"
                            onmouseover="this.style.background='var(--primary-color)';this.style.color='#fff'"
                            onmouseout="this.style.background='rgba(0,40,112,0.08)';this.style.color='var(--primary-color)'">
                                <i class="bi bi-youtube"></i>
                            </a>
                            <a href="mailto:info@ntp.id"
                            style="width:40px;height:40px;background:rgba(0,40,112,0.08);display:flex;align-items:center;justify-content:center;border-radius:10px;color:var(--primary-color);text-decoration:none;transition:0.2s;"
                            onmouseover="this.style.background='var(--primary-color)';this.style.color='#fff'"
                            onmouseout="this.style.background='rgba(0,40,112,0.08)';this.style.color='var(--primary-color)'">
                                <i class="bi bi-envelope-fill"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Form --}}
            <div class="col-lg-7 fade-up">
                <div style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
                    <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:24px;">Kirim Pesan</h5>

                    @if(session('success'))
                        <div class="alert" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);border-radius:10px;color:#065f46;padding:14px 18px;margin-bottom:20px;">
                            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('kontak.send') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:13px;font-weight:600;color:#374151;">Nama Lengkap</label>
                                <div class="input-group-custom">
                                    <i class="bi bi-person"></i>
                                    <input type="text" name="name" placeholder="Nama kamu" required value="{{ old('name') }}">
                                </div>
                                @error('name')<small class="text-danger mt-1 d-block">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:13px;font-weight:600;color:#374151;">Email</label>
                                <div class="input-group-custom">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" name="email" placeholder="email@kamu.com" required value="{{ old('email') }}">
                                </div>
                                @error('email')<small class="text-danger mt-1 d-block">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-size:13px;font-weight:600;color:#374151;">Subjek</label>
                                <div class="input-group-custom">
                                    <i class="bi bi-chat-dots"></i>
                                    <input type="text" name="subject" placeholder="Topik pertanyaanmu" required value="{{ old('subject') }}">
                                </div>
                                @error('subject')<small class="text-danger mt-1 d-block">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-size:13px;font-weight:600;color:#374151;">Pesan</label>
                                <textarea name="message" rows="5" required
                                    style="width:100%;border:1px solid #e5e7eb;border-radius:10px;padding:12px 14px;font-size:14px;outline:none;resize:vertical;transition:0.2s;background:#f9fafb;"
                                    onfocus="this.style.borderColor='var(--primary-color)';this.style.boxShadow='0 0 0 3px rgba(0,40,112,0.1)'"
                                    onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'"
                                    placeholder="Tuliskan pertanyaan atau pesanmu di sini...">{{ old('message') }}</textarea>
                                @error('message')<small class="text-danger mt-1 d-block">{{ $message }}</small>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-secondary-custom px-4 py-2 w-100" style="border-radius:10px;">
                                    <i class="bi bi-send me-2"></i>Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@include('components.footer')

@endsection 