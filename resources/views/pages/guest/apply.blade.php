@extends('layouts.main')

@section('content')

<section style="padding: 100px 0 80px;">
<div class="container" style="max-width: 780px;">

    <div class="fade-up mb-4">
        <small class="section-label"><i class="bi bi-send me-2"></i>Form Lamaran</small>
        <h1 class="hero-title mt-2">Lamar — {{ $vacancy->title }}</h1>
        <p class="hero-subtitle">{{ $vacancy->division }}. Lengkapi 4 langkah berikut untuk mengirim lamaranmu.</p>
    </div>

    <div class="fade-up mb-4">
        <div class="d-flex align-items-center gap-2 flex-wrap" id="step-indicator">
            @foreach([
                ['icon'=>'bi-person','label'=>'Data Diri'],
                ['icon'=>'bi-mortarboard','label'=>'Pendidikan'],
                ['icon'=>'bi-briefcase','label'=>'Pengalaman'],
                ['icon'=>'bi-file-earmark','label'=>'Dokumen'],
            ] as $i => $s)
            <div class="step-pill {{ $i === 0 ? 'active' : '' }}" data-step="{{ $i }}">
                <i class="bi {{ $s['icon'] }}"></i> {{ $s['label'] }}
            </div>
            @if($i < 3)
            <div class="step-line"></div>
            @endif
            @endforeach
        </div>
    </div>

    @if($errors->any())
    <div class="fade-up" style="background:rgba(186,26,26,0.08);border:1px solid rgba(186,26,26,0.2);border-radius:10px;padding:14px 18px;margin-bottom:20px;">
        <strong style="color:#ba1a1a;">Ada kesalahan:</strong>
        <ul style="margin:8px 0 0;color:#ba1a1a;font-size:14px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('apply.store', $vacancy->id) }}" method="POST" enctype="multipart/form-data" id="apply-form">
        @csrf

        {{-- STEP 1: DATA DIRI --}}
        <div class="step-content fade-up" data-step="0">
            <div style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
                <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:24px;">Data Diri</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="apply-label">Nama Lengkap</label>
                        <input type="text" class="apply-input" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" disabled>
                        <small class="text-muted" style="font-size:11px;">Sesuai akun terdaftar</small>
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Email</label>
                        <input type="email" class="apply-input" value="{{ Auth::user()->email }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">No. Telepon / WhatsApp *</label>
                        <input type="text" name="phone" id="phone" class="apply-input" placeholder="+62 812 3456 7890" value="{{ old('phone') }}">
                        @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Tanggal Lahir</label>
                        <input type="date" name="birthdate" class="apply-input" value="{{ old('birthdate') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Jenis Kelamin *</label>
                        <select name="gender" id="gender" class="apply-input">
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Domisili / Kota *</label>
                        <input type="text" name="address" id="address" class="apply-input" placeholder="Kota / Kabupaten" value="{{ old('address') }}">
                        @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 2: PENDIDIKAN --}}
        <div class="step-content fade-up" data-step="1" style="display:none;">
            <div style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 style="font-weight:700;color:var(--primary-color);margin:0;">Riwayat Pendidikan</h5>
                    <button type="button" class="btn btn-secondary-custom btn-sm px-3" id="add-edu" style="border-radius:8px;font-size:13px;">
                        <i class="bi bi-plus me-1"></i>Tambah
                    </button>
                </div>
                <div id="edu-list" class="d-flex flex-column gap-3">
                    <div class="edu-entry" style="background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="apply-label">Jenjang *</label>
                                <select name="education[0][level]" class="apply-input">
                                    <option value="">Pilih</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="apply-label">Nama Institusi *</label>
                                <input type="text" name="education[0][institution]" class="apply-input" placeholder="Universitas / Sekolah">
                            </div>
                            <div class="col-md-6">
                                <label class="apply-label">Jurusan / Program Studi</label>
                                <input type="text" name="education[0][major]" class="apply-input" placeholder="Teknik Informatika">
                            </div>
                            <div class="col-md-3">
                                <label class="apply-label">Tahun Masuk</label>
                                <input type="number" name="education[0][year_start]" class="apply-input year-input" placeholder="2018" min="1900" max="2030">
                            </div>
                            <div class="col-md-3">
                                <label class="apply-label">Tahun Lulus</label>
                                <input type="number" name="education[0][year_end]" class="apply-input year-input" placeholder="2022" min="1900" max="2030">
                            </div>
                            <div class="col-md-3">
                                <label class="apply-label">IPK / Nilai</label>
                                <input type="text" name="education[0][gpa]" class="apply-input" placeholder="3.75">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 3: PENGALAMAN --}}
        <div class="step-content fade-up" data-step="2" style="display:none;">
            <div style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 style="font-weight:700;color:var(--primary-color);margin:0;">Pengalaman Kerja</h5>
                    <button type="button" class="btn btn-secondary-custom btn-sm px-3" id="add-exp" style="border-radius:8px;font-size:13px;">
                        <i class="bi bi-plus me-1"></i>Tambah
                    </button>
                </div>
                <p style="font-size:13px;color:#64748b;margin-bottom:16px;">Kosongkan jika belum memiliki pengalaman kerja.</p>
                <div id="exp-list" class="d-flex flex-column gap-3">
                    <div class="exp-entry" style="background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="apply-label">Posisi / Jabatan</label>
                                <input type="text" name="experience[0][position]" class="apply-input" placeholder="Software Engineer">
                            </div>
                            <div class="col-md-6">
                                <label class="apply-label">Nama Perusahaan</label>
                                <input type="text" name="experience[0][company]" class="apply-input" placeholder="PT Contoh Indonesia">
                            </div>
                            <div class="col-md-3">
                                <label class="apply-label">Tahun Mulai</label>
                                <input type="number" name="experience[0][year_start]" class="apply-input year-input" placeholder="2020" min="1900" max="2030">
                            </div>
                            <div class="col-md-3">
                                <label class="apply-label">Tahun Selesai</label>
                                <input type="number" name="experience[0][year_end]" class="apply-input year-input" placeholder="2023" min="1900" max="2030">
                            </div>
                            <div class="col-md-6">
                                <label class="apply-label">Masih Bekerja?</label>
                                <select name="experience[0][current]" class="apply-input">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya (masih aktif)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="apply-label">Deskripsi Pekerjaan</label>
                                <textarea name="experience[0][description]" class="apply-input" rows="3"
                                    placeholder="Jelaskan tanggung jawab dan pencapaian kamu..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 4: DOKUMEN --}}
        <div class="step-content fade-up" data-step="3" style="display:none;">
            <div style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
                <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:24px;">Upload Dokumen</h5>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="apply-label">CV / Resume * <span style="font-size:11px;color:#64748b;">(PDF, maks 5MB)</span></label>
                        <div class="upload-area" id="cv-area" style="position:relative;">
                            <i class="bi bi-file-earmark-pdf" style="font-size:32px;color:var(--primary-color);margin-bottom:8px;display:block;"></i>
                            <p style="margin:0;font-size:14px;font-weight:600;color:var(--primary-color);">Klik atau drag & drop CV kamu</p>
                            <p style="margin:4px 0 0;font-size:12px;color:#64748b;">Format PDF, maksimal 5MB</p>
                            <input type="file" id="cv-input" name="resume" accept=".pdf" style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;">
                        </div>
                        <div id="cv-name" style="display:none;margin-top:8px;padding:10px 14px;background:#f0fdf4;border-radius:8px;border:1px solid #bbf7d0;font-size:13px;color:#166534;">
                            <i class="bi bi-check-circle me-2"></i><span></span>
                        </div>
                        @error('resume')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12">
                        <label class="apply-label">Dokumen Pendukung <span style="font-size:11px;color:#64748b;">(sertifikat, portofolio — PDF/JPG, maks 5MB/file)</span></label>
                        <div class="upload-area" id="docs-area" style="position:relative;">
                            <i class="bi bi-paperclip" style="font-size:28px;color:#94a3b8;margin-bottom:8px;display:block;"></i>
                            <p style="margin:0;font-size:14px;font-weight:600;color:#64748b;">Tambah dokumen pendukung</p>
                            <p style="margin:4px 0 0;font-size:12px;color:#94a3b8;">Bisa pilih beberapa file sekaligus</p>
                            <input type="file" id="docs-input" accept=".pdf,.jpg,.jpeg,.png" multiple style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;">
                        </div>
                        {{-- Hidden inputs untuk dokumen terkumpul --}}
                        <div id="docs-hidden"></div>
                        <div id="docs-list" class="d-flex flex-column gap-2 mt-2"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="d-flex justify-content-between mt-4 fade-up">
            <button type="button" id="btn-prev" class="btn px-4 py-2"
                style="border-radius:10px;display:none;align-items:center;">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </button>
            <div class="ms-auto d-flex gap-2">
                <button type="button" id="btn-next" class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;">
                    Lanjut <i class="bi bi-arrow-right ms-2"></i>
                </button>
                <button type="button" id="btn-submit" class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;display:none;">
                    <i class="bi bi-send me-2"></i>Kirim Lamaran
                </button>
            </div>
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
    <script src="{{ asset('js/apply.js') }}"></script>
@endpush