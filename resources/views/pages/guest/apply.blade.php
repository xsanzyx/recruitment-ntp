@extends('layouts.main')

@section('content')

<section style="padding: 100px 0 80px;">
<div class="container" style="max-width: 780px;">


    {{-- Header --}}
    <div class="fade-up mb-4">
        <small class="section-label"><i class="bi bi-send me-2"></i>Form Lamaran</small>
        <h1 class="hero-title mt-2">Lamar — {{ $vacancy->title }}</h1>
        <p class="hero-subtitle">{{ $vacancy->division }}. Lengkapi 4 langkah berikut untuk mengirim lamaranmu.</p>
    </div>

    {{-- Step Indicator --}}
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

    {{-- Error global --}}
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

    {{-- Form --}}
    <form action="{{ route('apply.store', $vacancy->id) }}" method="POST" enctype="multipart/form-data" id="apply-form">
        @csrf

        {{-- ===== STEP 1: DATA DIRI ===== --}}
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
                        <input type="text" name="phone" class="apply-input" placeholder="+62 812 3456 7890" required value="{{ old('phone') }}">
                        @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Tanggal Lahir</label>
                        <input type="date" name="birthdate" class="apply-input" value="{{ old('birthdate') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Jenis Kelamin</label>
                        <select name="gender" class="apply-input">
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Domisili / Kota</label>
                        <input type="text" name="address" class="apply-input" placeholder="Kota / Kabupaten" value="{{ old('address') }}">
                    </div>
                    <div class="col-12">
                        <label class="apply-label">Ringkasan Singkat (opsional)</label>
                        <textarea name="summary" class="apply-input" rows="4" maxlength="500"
                            placeholder="Ceritakan singkat tentang dirimu, motivasi, dan keunggulan yang kamu bawa..">{{ old('summary') }}</textarea>
                        <small class="text-muted" style="font-size:11px;" id="summary-count">0/500</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== STEP 2: PENDIDIKAN ===== --}}
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
                                <input type="number" name="education[0][year_start]" class="apply-input" placeholder="2018" min="1990" max="2030">
                            </div>
                            <div class="col-md-3">
                                <label class="apply-label">Tahun Lulus</label>
                                <input type="number" name="education[0][year_end]" class="apply-input" placeholder="2022" min="1990" max="2030">
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

        {{-- ===== STEP 3: PENGALAMAN ===== --}}
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
                                <input type="number" name="experience[0][year_start]" class="apply-input" placeholder="2020" min="1990" max="2030">
                            </div>
                            <div class="col-md-3">
                                <label class="apply-label">Tahun Selesai</label>
                                <input type="number" name="experience[0][year_end]" class="apply-input" placeholder="2023" min="1990" max="2030">
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

        {{-- ===== STEP 4: DOKUMEN ===== --}}
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
                            <input type="file" name="resume" accept=".pdf" required style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;">
                        </div>
                        <div id="cv-name" style="display:none;margin-top:8px;padding:10px 14px;background:#f0fdf4;border-radius:8px;border:1px solid #bbf7d0;font-size:13px;color:#166534;">
                            <i class="bi bi-check-circle me-2"></i><span></span>
                        </div>
                        @error('resume')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12">
                        <label class="apply-label">Cover Letter (opsional)</label>
                        <textarea name="cover_letter" class="apply-input" rows="5"
                            placeholder="Tuliskan motivasimu melamar posisi ini...">{{ old('cover_letter') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="apply-label">Dokumen Pendukung <span style="font-size:11px;color:#64748b;">(sertifikat, portofolio — PDF/JPG, maks 5MB/file)</span></label>
                        <div class="upload-area" id="docs-area" style="position:relative;">
                            <i class="bi bi-paperclip" style="font-size:28px;color:#94a3b8;margin-bottom:8px;display:block;"></i>
                            <p style="margin:0;font-size:14px;font-weight:600;color:#64748b;">Tambah dokumen pendukung</p>
                            <p style="margin:4px 0 0;font-size:12px;color:#94a3b8;">Bisa pilih beberapa file sekaligus</p>
                            <input type="file" name="documents[]" accept=".pdf,.jpg,.jpeg,.png" multiple style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;">
                        </div>
                        <div id="docs-list" class="d-flex flex-column gap-2 mt-2"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="d-flex justify-content-between mt-4 fade-up">
            <button type="button" id="btn-prev" class="btn px-4 py-2"
                style="border-radius:10px;border:1px solid #e5e7eb;color:#64748b;display:none;align-items:center;">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </button>
            <div class="ms-auto d-flex gap-2">
                <button type="button" id="btn-next" class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;">
                    Lanjut <i class="bi bi-arrow-right ms-2"></i>
                </button>
                {{-- FIX: type="submit" bukan type="button" --}}
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
<script>
let currentStep = 0;
const totalSteps = 4;

const steps     = document.querySelectorAll('.step-content');
const pills     = document.querySelectorAll('.step-pill');
const btnNext   = document.getElementById('btn-next');
const btnPrev   = document.getElementById('btn-prev');
const btnSubmit = document.getElementById('btn-submit');

function goToStep(step) {
    steps.forEach((s, i) => s.style.display = i === step ? 'block' : 'none');
    pills.forEach((p, i) => {
        p.classList.toggle('active', i === step);
        p.classList.toggle('done', i < step);
    });
    btnPrev.style.display   = step > 0 ? 'inline-flex' : 'none';
    btnNext.style.display   = step < totalSteps - 1 ? 'inline-flex' : 'none';
    btnSubmit.style.display = step === totalSteps - 1 ? 'inline-flex' : 'none';
    currentStep = step;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

btnNext.addEventListener('click', () => {
    if (currentStep < totalSteps - 1) {
        if (!validateStep(currentStep)) return;
        goToStep(currentStep + 1);
    }
});

function validateStep(step) {
    let valid = true;

    if (step === 0) {
        const phone = document.querySelector('[name="phone"]');
        if (!phone.value.trim()) {
            phone.style.borderColor = '#ba1a1a';
            phone.style.boxShadow = '0 0 0 3px rgba(186,26,26,0.1)';
            phone.focus();
            showStepError('Nomor telepon wajib diisi.');
            valid = false;
        } else {
            phone.style.borderColor = '';
            phone.style.boxShadow = '';
            hideStepError();
        }
    }

    if (step === 1) {
        const institution = document.querySelector('[name="education[0][institution]"]');
        const level = document.querySelector('[name="education[0][level]"]');
        if (!institution.value.trim() || !level.value) {
            if (!level.value) {
                level.style.borderColor = '#ba1a1a';
                level.focus();
            }
            if (!institution.value.trim()) {
                institution.style.borderColor = '#ba1a1a';
                institution.focus();
            }
            showStepError('Jenjang dan nama institusi wajib diisi.');
            valid = false;
        } else {
            institution.style.borderColor = '';
            level.style.borderColor = '';
            hideStepError();
        }
    }

    return valid;
}

function showStepError(msg) {
    let el = document.getElementById('step-error');
    if (!el) {
        el = document.createElement('div');
        el.id = 'step-error';
        el.style.cssText = 'background:rgba(186,26,26,0.08);border:1px solid rgba(186,26,26,0.2);border-radius:10px;padding:12px 16px;color:#ba1a1a;font-size:14px;margin-top:12px;';
        document.getElementById('apply-form').prepend(el);
    }
    el.innerHTML = `<i class="bi bi-exclamation-circle me-2"></i>${msg}`;
    el.style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hideStepError() {
    const el = document.getElementById('step-error');
    if (el) el.style.display = 'none';
}

btnPrev.addEventListener('click', () => {
    if (currentStep > 0) goToStep(currentStep - 1);
});

// Summary counter
const summaryEl = document.querySelector('[name="summary"]');
const countEl   = document.getElementById('summary-count');
if (summaryEl && countEl) {
    summaryEl.addEventListener('input', () => {
        countEl.textContent = summaryEl.value.length + '/500';
    });
}

// CV file preview
const cvInput = document.querySelector('[name="resume"]');
const cvName  = document.getElementById('cv-name');
if (cvInput) {
    cvInput.addEventListener('change', () => {
        if (cvInput.files[0]) {
            cvName.style.display = 'block';
            cvName.querySelector('span').textContent = cvInput.files[0].name;
        }
    });
}

// Docs file preview
const docsInput = document.querySelector('[name="documents[]"]');
const docsList  = document.getElementById('docs-list');
if (docsInput) {
    docsInput.addEventListener('change', () => {
        docsList.innerHTML = '';
        [...docsInput.files].forEach(f => {
            const div = document.createElement('div');
            div.style.cssText = 'padding:8px 12px;background:#f8faff;border-radius:8px;border:1px solid #e8edf5;font-size:13px;color:#374151;display:flex;align-items:center;gap:8px;';
            div.innerHTML = `<i class="bi bi-paperclip" style="color:var(--primary-color);"></i>${f.name}`;
            docsList.appendChild(div);
        });
    });
}

// Add education entry
let eduCount = 1;
document.getElementById('add-edu').addEventListener('click', () => {
    const i = eduCount++;
    const entry = document.createElement('div');
    entry.className = 'edu-entry';
    entry.style.cssText = 'background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;position:relative;';
    entry.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" style="position:absolute;top:12px;right:12px;background:none;border:none;color:#94a3b8;cursor:pointer;font-size:16px;">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="apply-label">Jenjang</label>
                <select name="education[${i}][level]" class="apply-input">
                    <option value="">Pilih</option>
                    <option value="SMA/SMK">SMA/SMK</option>
                    <option value="D3">D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="apply-label">Nama Institusi</label>
                <input type="text" name="education[${i}][institution]" class="apply-input" placeholder="Universitas / Sekolah">
            </div>
            <div class="col-md-6">
                <label class="apply-label">Jurusan</label>
                <input type="text" name="education[${i}][major]" class="apply-input" placeholder="Teknik Informatika">
            </div>
            <div class="col-md-3">
                <label class="apply-label">Tahun Masuk</label>
                <input type="number" name="education[${i}][year_start]" class="apply-input" placeholder="2018">
            </div>
            <div class="col-md-3">
                <label class="apply-label">Tahun Lulus</label>
                <input type="number" name="education[${i}][year_end]" class="apply-input" placeholder="2022">
            </div>
            <div class="col-md-3">
                <label class="apply-label">IPK / Nilai</label>
                <input type="text" name="education[${i}][gpa]" class="apply-input" placeholder="3.75">
            </div>
        </div>`;
    document.getElementById('edu-list').appendChild(entry);
});

// Add experience entry
let expCount = 1;
document.getElementById('add-exp').addEventListener('click', () => {
    const i = expCount++;
    const entry = document.createElement('div');
    entry.className = 'exp-entry';
    entry.style.cssText = 'background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;position:relative;';
    entry.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" style="position:absolute;top:12px;right:12px;background:none;border:none;color:#94a3b8;cursor:pointer;font-size:16px;">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="apply-label">Posisi / Jabatan</label>
                <input type="text" name="experience[${i}][position]" class="apply-input" placeholder="Software Engineer">
            </div>
            <div class="col-md-6">
                <label class="apply-label">Nama Perusahaan</label>
                <input type="text" name="experience[${i}][company]" class="apply-input" placeholder="PT Contoh Indonesia">
            </div>
            <div class="col-md-3">
                <label class="apply-label">Tahun Mulai</label>
                <input type="number" name="experience[${i}][year_start]" class="apply-input" placeholder="2020">
            </div>
            <div class="col-md-3">
                <label class="apply-label">Tahun Selesai</label>
                <input type="number" name="experience[${i}][year_end]" class="apply-input" placeholder="2023">
            </div>
            <div class="col-md-6">
                <label class="apply-label">Masih Bekerja?</label>
                <select name="experience[${i}][current]" class="apply-input">
                    <option value="0">Tidak</option>
                    <option value="1">Ya (masih aktif)</option>
                </select>
            </div>
            <div class="col-12">
                <label class="apply-label">Deskripsi Pekerjaan</label>
                <textarea name="experience[${i}][description]" class="apply-input" rows="3" placeholder="Jelaskan tanggung jawab dan pencapaian kamu..."></textarea>
            </div>
        </div>`;
    document.getElementById('exp-list').appendChild(entry);
});
document.getElementById('btn-submit').addEventListener('click', () => {
    document.getElementById('apply-form').submit();
});
goToStep(0);
</script>
@endpush