<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Dashboard HR') — NTP Careers</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 1. Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#002870",
                        "primary": "#001544",
                    },
                    fontFamily: {
                        "stat-number": ["Inter"], "h3": ["Inter"], "h1": ["Inter"],
                        "label-caps": ["Inter"], "body-md": ["Inter"],
                        "body-lg": ["Inter"], "h2": ["Inter"]
                    },
                    fontSize: {
                        "stat-number": ["28px", {"lineHeight":"1","fontWeight":"700"}],
                        "h3": ["18px", {"lineHeight":"1.4","fontWeight":"600"}],
                        "h1": ["32px", {"lineHeight":"1.2","letterSpacing":"-0.02em","fontWeight":"700"}],
                        "label-caps": ["12px", {"lineHeight":"1.2","letterSpacing":"0.05em","fontWeight":"600"}],
                        "body-md": ["14px", {"lineHeight":"1.5","fontWeight":"400"}],
                        "body-lg": ["16px", {"lineHeight":"1.6","fontWeight":"400"}],
                        "h2": ["24px", {"lineHeight":"1.3","letterSpacing":"-0.01em","fontWeight":"600"}]
                    }
                }
            }
        }
    </script>

    {{-- 2. Icons & Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- 3. Base & Layout CSS (for exact public sidebar styling) --}}
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f6fafe; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f6fafe; }
        ::-webkit-scrollbar-thumb { background: #dfe3e7; border-radius: 4px; }

        /* MODAL */
        #vacancyModal { display: none; }
        #vacancyModal.open { display: flex; }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(.96) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        #vacancyModalCard { animation: modalIn .25s cubic-bezier(.22,1,.36,1) both; }
        
        /* OVERRIDE TOGGLE BTN Z-INDEX */
        .toggle-btn { z-index: 998; }
        
        /* Main content padding so it doesn't hide behind toggle button */
        #hrMain { padding-top: 60px; }
        @media(min-width: 1024px) {
            #hrMain { padding-top: 20px; }
            .toggle-btn { top: 20px; left: 20px; }
        }
        
        /* Fix double arrows on select elements with custom icons */
        select.appearance-none,
        .relative > select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: none !important;
        }
    </style>
    @stack('styles')
</head>
<body class="text-gray-900 antialiased min-h-screen">

{{-- ═══════════════ SIDEBAR (EXACTLY LIKE PUBLIC PAGE) ═══════════════ --}}
<div id="sidebar" class="sidebar flex flex-col z-[1000]">

    <div class="sidebar-brand flex justify-between items-start">
        <div>
            <div class="sidebar-brand-name">PT. Nusantara Turbin dan Propulsi</div>
            <div class="sidebar-brand-tag">CAREERS PORTAL</div>
        </div>
        <button onclick="toggleSidebar()" class="sidebar-close flex items-center justify-center">✕</button>
    </div>

    <ul class="sidebar-menu list-none p-0" style="flex:0;">
        <li class="mb-[1px]">
            <a href="{{ route('hr.dashboard') }}" class="{{ request()->routeIs('hr.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard HR
            </a>
        </li>
        <li class="mb-[1px]">
            <a href="{{ route('hr.vacancies.index') }}" class="{{ request()->routeIs('hr.vacancies.*') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i> Kelola Lowongan
            </a>
        </li>
        <li class="mb-[1px]">
            <a href="{{ route('hr.applications.index') }}" class="{{ request()->routeIs('hr.applications.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Kandidat & Lamaran
            </a>
        </li>
    </ul>

    <div class="sidebar-divider"></div>

    @if(Auth::user()->role === 'admin')
    <ul class="sidebar-menu list-none p-0" style="flex:0;">
        <li class="mb-[1px]">
            <a href="{{ route('admin.dashboard') }}">
                <i class="bi bi-shield-lock"></i> Panel Admin
            </a>
        </li>
    </ul>

    <div class="sidebar-divider"></div>
    @endif

    <ul class="sidebar-menu list-none p-0" style="flex:0;">
        <li class="mb-[1px]">
            <a href="{{ route('home') }}">
                <i class="bi bi-house-door"></i> Beranda Publik
            </a>
        </li>
        <li class="mb-[1px]">
            <a href="{{ route('lowongan') }}">
                <i class="bi bi-search"></i> Lihat Lowongan
            </a>
        </li>
    </ul>

    <div class="sidebar-divider"></div>

    <div class="sidebar-bottom mt-auto">
        <div class="cta-box mb-3 text-center">
            
            {{-- Avatar --}}
            <div style="width:56px;height:56px;border-radius:50%;overflow:hidden;border:2px solid rgba(0,40,112,0.15);margin:0 auto 10px;">
                @if(Auth::user()->avatar)
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar"
                         style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div style="width:100%;height:100%;background:rgba(0,40,112,0.06);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-person-fill" style="font-size:26px;color:var(--primary-color);"></i>
                    </div>
                @endif
            </div>

            <small class="text-[#94a3b8] block mb-2" style="font-size:11px;">Selamat datang,</small>
            <strong style="color:var(--primary-color);font-size:14px;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong>
            <div style="font-size:11px; color:#94a3b8; margin-top:2px;">HR Representative</div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="guest-box logout-box w-full text-left" style="width:100%;">
                <i class="bi bi-box-arrow-right"></i>
                <div class="text-left leading-tight">
                    <strong style="color:rgba(239,68,68,0.85);font-size:13px;">Logout</strong><br>
                    <small style="color:rgba(239,68,68,0.5);font-size:11px;">Keluar dari akun</small>
                </div>
            </button>
        </form>
    </div>
</div>

<button class="toggle-btn" onclick="toggleSidebar()">☰</button>
<div id="overlay" onclick="toggleSidebar()"></div>

{{-- ═══════════════ MAIN CONTENT ═══════════════ --}}
<main id="hrMain" class="min-h-screen flex flex-col transition-all lg:ml-16">
    <div class="p-6 lg:p-8 flex-grow">
        @yield('content')
    </div>
</main>

{{-- ═══════════════ MODAL TAMBAH LOWONGAN ═══════════════ --}}
<div id="vacancyModal"
     class="fixed inset-0 z-[1001] items-center justify-center p-4"
     style="background:rgba(15,23,42,.6);backdrop-filter:blur(4px);">

    <div id="vacancyModalCard"
         class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden">

        {{-- Modal Header --}}
        <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-[#002870]"
                      style="font-variation-settings:'FILL' 1;font-size:22px;">work</span>
                <div>
                    <h2 class="font-semibold text-[#002870] text-lg leading-tight">Tambah Lowongan Baru</h2>
                    <p class="text-sm text-gray-500">Lengkapi detail lowongan untuk dipublikasikan.</p>
                </div>
            </div>
            <button onclick="closeVacancyModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                <span class="material-symbols-outlined" style="font-size:20px;">close</span>
            </button>
        </div>

        {{-- Modal Form --}}
        <form method="POST" action="{{ route('hr.vacancies.store') }}" id="vacancyModalForm">
            @csrf
            <div class="p-8 space-y-5 max-h-[70vh] overflow-y-auto">
            
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-red-500" style="font-size:20px;">error</span>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-red-800">Gagal menyimpan:</h3>
                                <ul class="mt-1 text-xs text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Row 1: Judul + Departemen --}}
                <div class="grid grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Judul Lowongan *</label>
                        <input type="text" name="title" required value="{{ old('title') }}" placeholder="cth: Frontend Developer"
                               class="h-11 px-4 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none
                                      focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                        <p class="modal-error text-red-500 text-xs hidden" data-field="title"></p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Departemen *</label>
                        <input type="text" name="department" required value="{{ old('department') }}" placeholder="cth: Engineering"
                               class="h-11 px-4 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none
                                      focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                        <p class="modal-error text-red-500 text-xs hidden" data-field="department"></p>
                    </div>
                </div>

                {{-- Row 2: Divisi + Tipe --}}
                <div class="grid grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Divisi *</label>
                        <input type="text" name="division" required value="{{ old('division') }}" placeholder="cth: Information Technology"
                               class="h-11 px-4 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none
                                      focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Tipe Pekerjaan *</label>
                        <div class="relative">
                            <select name="type" required
                                    class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none
                                           appearance-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                                <option value="">Pilih tipe...</option>
                                <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-400 pointer-events-none"
                                  style="font-size:18px;">expand_more</span>
                        </div>
                    </div>
                </div>

                {{-- Deadline --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Deadline *</label>
                    <input type="date" name="deadline" required max="9999-12-31"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('deadline') }}"
                           class="h-11 px-4 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none
                                  focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                </div>

                {{-- Deskripsi --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Deskripsi Pekerjaan *</label>
                    <textarea name="description" required rows="3"
                              placeholder="Jelaskan tanggung jawab dan lingkup pekerjaan..."
                              class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none resize-none
                                     focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">{{ old('description') }}</textarea>
                </div>

                {{-- Persyaratan --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Persyaratan *</label>
                    <textarea name="requirements" required rows="3"
                              placeholder="Tuliskan kualifikasi dan persyaratan kandidat..."
                              class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none resize-none
                                     focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">{{ old('requirements') }}</textarea>
                </div>

                {{-- Kriteria Eligibility --}}
                <div class="border border-dashed border-gray-300 rounded-lg p-5 space-y-4 bg-gray-50/50">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870] flex items-center gap-2">
                        <span class="material-symbols-outlined" style="font-size:16px;">filter_alt</span>
                        Kriteria Pelamar
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold text-gray-500">Umur Minimal</label>
                            <input type="number" name="min_age" value="{{ old('min_age') }}" placeholder="cth: 18" min="15" max="65"
                                   class="h-10 px-3 bg-white border border-gray-200 rounded-lg text-sm outline-none
                                          focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold text-gray-500">Umur Maksimal</label>
                            <input type="number" name="max_age" value="{{ old('max_age') }}" placeholder="cth: 35" min="15" max="65"
                                   class="h-10 px-3 bg-white border border-gray-200 rounded-lg text-sm outline-none
                                          focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold text-gray-500">Jenis Kelamin</label>
                            <div class="relative">
                                <select name="gender_requirement"
                                        class="w-full h-10 px-3 bg-white border border-gray-200 rounded-lg text-sm outline-none
                                               appearance-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10">
                                    <option value="Semua" {{ old('gender_requirement') == 'Semua' ? 'selected' : '' }}>Semua</option>
                                    <option value="Laki-laki" {{ old('gender_requirement') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender_requirement') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-2 top-2 text-gray-400 pointer-events-none" style="font-size:16px;">expand_more</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold text-gray-500">Pendidikan Minimal</label>
                            <div class="relative">
                                <select name="min_education"
                                        class="w-full h-10 px-3 bg-white border border-gray-200 rounded-lg text-sm outline-none
                                               appearance-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10">
                                    <option value="">Tidak ada syarat</option>
                                    <option value="SMA/SMK" {{ old('min_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                    <option value="D3" {{ old('min_education') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ old('min_education') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('min_education') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('min_education') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-2 top-2 text-gray-400 pointer-events-none" style="font-size:16px;">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="px-8 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                <button type="button" onclick="closeVacancyModal()"
                        class="px-6 h-11 text-sm font-semibold text-gray-600 hover:bg-gray-200 transition-colors rounded-lg">
                    Batal
                </button>
                <button type="submit"
                        class="flex items-center gap-2 px-6 h-11 text-sm font-bold rounded-lg transition-all
                               active:scale-95 hover:brightness-95"
                        style="background:#f8b830;color:#002870;">
                    <span class="material-symbols-outlined" style="font-size:16px;">add</span>
                    Tambah Lowongan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Success / Error flash --}}
@if(session('success'))
<div id="flashMsg"
     class="fixed bottom-6 right-6 z-[9999] flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg text-sm font-semibold text-white"
     style="background:#002870;animation:modalIn .3s both;">
    <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>
    {{ session('success') }}
</div>
<script>setTimeout(()=>{ const el=document.getElementById('flashMsg'); if(el) el.remove(); }, 3500);</script>
@endif

@if(session('error'))
<div id="flashMsgErr"
     class="fixed bottom-6 right-6 z-[9999] flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg text-sm font-semibold text-white bg-red-600"
     style="animation:modalIn .3s both;">
    <span class="material-symbols-outlined" style="font-size:18px;">error</span>
    {{ session('error') }}
</div>
<script>setTimeout(()=>{ const el=document.getElementById('flashMsgErr'); if(el) el.remove(); }, 3500);</script>
@endif

<script src="{{ asset('js/app.js') }}"></script>
<script>
    /* ── Vacancy Modal ── */
    function openVacancyModal() {
        document.getElementById('vacancyModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    
    @if ($errors->any())
    // Auto-open modal if there are validation errors
    document.addEventListener('DOMContentLoaded', function() {
        openVacancyModal();
    });
    @endif
    function closeVacancyModal() {
        document.getElementById('vacancyModal').classList.remove('open');
        document.body.style.overflow = '';
    }
    /* Close on backdrop click */
    document.getElementById('vacancyModal').addEventListener('click', function(e){
        if(e.target === this) closeVacancyModal();
    });
    /* ESC to close */
    document.addEventListener('keydown', e => {
        if(e.key === 'Escape') closeVacancyModal();
    });
</script>

@stack('scripts')
</body>
</html>
