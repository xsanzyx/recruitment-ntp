<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Dashboard HR') — NTP Careers</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "secondary-container": "#ffbe37",
                        "background": "#f6fafe",
                        "surface": "#f6fafe",
                        "on-surface": "#171c1f",
                        "primary-container": "#002870",
                        "on-primary": "#ffffff",
                        "on-background": "#171c1f",
                        "on-surface-variant": "#444651",
                        "outline": "#747682",
                        "outline-variant": "#c4c6d2",
                        "error": "#ba1a1a",
                        "surface-container": "#eaeef2",
                        "surface-container-low": "#f0f4f8",
                        "surface-container-high": "#e5e9ed",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#001544",
                        "secondary": "#7c5800",
                    },
                    spacing: {
                        "md": "24px", "xs": "8px", "base": "4px",
                        "xl": "48px", "sm": "16px", "lg": "32px",
                        "container-max": "1440px"
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
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f6fafe; }
        ::-webkit-scrollbar-thumb { background: #dfe3e7; border-radius: 4px; }

        /* ══════════════════════════════
           SIDEBAR — dark navy (matches main.blade)
        ══════════════════════════════ */
        #hrSidebar {
            background: linear-gradient(180deg, #001d54 0%, #002870 100%);
            width: 280px;
            position: fixed; left: 0; top: 0; height: 100vh;
            display: flex; flex-direction: column;
            z-index: 50;
            overflow: hidden;                          /* clips text on collapse */
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0,0,0,.2);
        }
        #hrSidebar.collapsed { width: 72px; }

        /* ── Brand row ── */
        .hr-brand-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            min-height: 72px;
            flex-shrink: 0;
        }
        .hr-brand-text {
            display: flex; flex-direction: column;
            overflow: hidden; white-space: nowrap;
            transition: opacity 0.2s, width 0.35s;
            opacity: 1; width: auto;
        }
        #hrSidebar.collapsed .hr-brand-text {
            opacity: 0; width: 0;
        }
        .hr-brand-name  { font-size:17px; font-weight:800; color:#fff; letter-spacing:-.01em; }
        .hr-brand-tag   { font-size:10px; font-weight:700; letter-spacing:.15em; text-transform:uppercase; color:#f8b830; margin-top:2px; }

        /* Toggle button — always centered when collapsed */
        .hr-toggle-btn {
            flex-shrink: 0;
            width: 36px; height: 36px;
            border-radius: 10px; border: none; cursor: pointer;
            background: rgba(255,255,255,.1); color: rgba(255,255,255,.7);
            display: flex; align-items: center; justify-content: center;
            transition: background .2s;
        }
        .hr-toggle-btn:hover { background: rgba(255,255,255,.18); color: #fff; }
        #hrSidebar.collapsed .hr-toggle-btn { margin: 0 auto; }

        /* ── Section labels ── */
        .hr-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: .12em;
            text-transform: uppercase; color: rgba(255,255,255,.25);
            padding: 0 14px; margin: 16px 0 4px;
            white-space: nowrap;
            transition: opacity .2s;
        }
        #hrSidebar.collapsed .hr-section-label { opacity: 0; }

        /* ── Nav items ── */
        .hr-nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px; font-size: 14px; font-weight: 500;
            color: rgba(255,255,255,.6); border-radius: 10px;
            text-decoration: none; transition: background .2s, color .2s;
            margin-bottom: 2px; white-space: nowrap;
            overflow: hidden;
        }
        .hr-nav-item:hover { background: rgba(255,255,255,.08); color: #fff; }
        .hr-nav-item.active { background: rgba(248,184,48,.12); color: #f8b830; font-weight: 600; }
        .hr-nav-item .mat-icon { font-size: 20px; width: 22px; text-align: center; flex-shrink: 0; }
        .hr-nav-item .nav-label { transition: opacity 0.15s, width 0.35s cubic-bezier(0.4, 0, 0.2, 1); white-space: nowrap; }
        #hrSidebar.collapsed .hr-nav-item .nav-label { opacity: 0; width: 0; overflow: hidden; }

        /* When collapsed, center the icon */
        #hrSidebar.collapsed .hr-nav-item { padding: 10px 0; justify-content: center; gap: 0; }

        /* ── Divider ── */
        .hr-divider { height: 1px; background: rgba(255,255,255,.06); margin: 8px 12px; }

        /* ── Footer info box ── */
        .hr-footer-info {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.06);
            border-radius: 12px; padding: 12px 14px; margin-bottom: 10px;
            transition: opacity .2s, max-height .3s, padding .3s, margin .3s;
            overflow: hidden; max-height: 100px; opacity: 1;
        }
        #hrSidebar.collapsed .hr-footer-info {
            opacity: 0; max-height: 0; padding: 0; margin: 0;
        }

        /* ── Logout button (special nav-item) ── */
        .hr-logout-btn {
            display: flex; align-items: center; gap: 12px;
            width: 100%; padding: 10px 14px; font-size: 14px; font-weight: 500;
            color: rgba(239,68,68,.7); border-radius: 10px;
            border: 1px solid rgba(239,68,68,.2); background: transparent;
            cursor: pointer; transition: background .2s, color .2s;
            white-space: nowrap; overflow: hidden;
        }
        .hr-logout-btn:hover { background: rgba(239,68,68,.08); color: #ef4444; }
        .hr-logout-btn .mat-icon { font-size: 20px; width: 22px; text-align: center; flex-shrink: 0; }
        .hr-logout-btn .nav-label { transition: opacity .15s; }
        #hrSidebar.collapsed .hr-logout-btn .nav-label { opacity: 0; width: 0; overflow: hidden; }
        #hrSidebar.collapsed .hr-logout-btn { padding: 10px 0; justify-content: center; gap: 0; border-color: transparent; }

        /* ══════════════════════════════
           MAIN CONTENT SHIFT
        ══════════════════════════════ */
        #hrMain { margin-left: 280px; transition: margin-left 0.35s cubic-bezier(0.4, 0, 0.2, 1); }
        #hrMain.collapsed { margin-left: 72px; }

        /* ══════════════════════════════
           CONTENT BLUR OVERLAY (desktop expand)
           Matches #overlay in main.blade / layout.css
        ══════════════════════════════ */
        #hrBlurOverlay {
            position: fixed;
            inset: 0 0 0 280px;          /* sits over main content, right of sidebar */
            background: rgba(0,20,60,.45);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            opacity: 0; visibility: hidden;
            transition: opacity .35s cubic-bezier(.4,0,.2,1),
                        visibility .35s cubic-bezier(.4,0,.2,1);
            z-index: 49;                  /* below sidebar (50), above content */
            cursor: pointer;
        }
        #hrBlurOverlay.active   { opacity: 1; visibility: visible; }
        /* When collapsed, overlay is hidden — sidebar icon-only, no need to blur */

        /* ══════════════════════════════
           MODAL
        ══════════════════════════════ */
        #vacancyModal { display: none; }
        #vacancyModal.open { display: flex; }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(.96) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        #vacancyModalCard { animation: modalIn .25s cubic-bezier(.22,1,.36,1) both; }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-surface antialiased min-h-screen">

{{-- Mobile overlay --}}
<div id="hrOverlay" onclick="closeHrSidebar()"
     class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"></div>

{{-- Desktop blur overlay (active when sidebar is expanded) --}}
<div id="hrBlurOverlay" onclick="toggleHrCollapse()"></div>

{{-- ═══════════════ SIDEBAR ═══════════════ --}}
<aside id="hrSidebar">

    {{-- Brand + toggle row --}}
    <div class="hr-brand-row">
        <div class="hr-brand-text">
            <div class="hr-brand-name">NTP Careers</div>
            <div class="hr-brand-tag">HR Panel</div>
        </div>
        <button class="hr-toggle-btn" onclick="toggleHrCollapse()" title="Toggle Sidebar">
            <span class="material-symbols-outlined" style="font-size:18px;">menu</span>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 pt-3 pb-2">

        <div class="hr-section-label">Menu</div>

        <a href="{{ route('home') }}"
           class="hr-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <span class="material-symbols-outlined mat-icon">home</span>
            <span class="nav-label">Beranda</span>
        </a>
        <a href="{{ route('home') }}#lowongan" class="hr-nav-item">
            <span class="material-symbols-outlined mat-icon">public</span>
            <span class="nav-label">Lihat Lowongan</span>
        </a>

        <div class="hr-divider"></div>

        <div class="hr-section-label">Panel HR</div>

        <a href="{{ route('hr.dashboard') }}"
           class="hr-nav-item {{ request()->routeIs('hr.dashboard') ? 'active' : '' }}">
            <span class="material-symbols-outlined mat-icon">space_dashboard</span>
            <span class="nav-label">Dashboard</span>
        </a>
        <a href="{{ route('hr.vacancies.index') }}"
           class="hr-nav-item {{ request()->routeIs('hr.vacancies.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined mat-icon">post_add</span>
            <span class="nav-label">Kelola Lowongan</span>
        </a>
        <a href="{{ route('hr.applications.index') }}"
           class="hr-nav-item {{ request()->routeIs('hr.applications.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined mat-icon">groups</span>
            <span class="nav-label">Kandidat & Lamaran</span>
        </a>

    </nav>

    {{-- Footer --}}
    <div class="px-3 pb-4" style="border-top:1px solid rgba(255,255,255,.06); padding-top:12px;">
        <div class="hr-footer-info">
            <div style="font-size:11px; color:rgba(255,255,255,.4); margin-bottom:3px;">Masuk sebagai</div>
            <div style="font-size:13px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
            </div>
            <div style="font-size:10px; font-weight:600; color:#f8b830; text-transform:uppercase; letter-spacing:.08em; margin-top:2px;">
                {{ ucfirst(Auth::user()->role) }}
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="hr-logout-btn">
                <span class="material-symbols-outlined mat-icon">logout</span>
                <span class="nav-label">Keluar</span>
            </button>
        </form>
    </div>

</aside>

{{-- ═══════════════ MAIN CONTENT ═══════════════ --}}
<main id="hrMain" class="min-h-screen flex flex-col bg-background transition-all">

    {{-- Mobile top bar --}}
    <div class="lg:hidden flex items-center justify-between px-5 py-4 bg-white border-b border-gray-200 sticky top-0 z-30">
        <div style="font-size:18px;font-weight:800;color:#002870;">NTP Careers</div>
        <button onclick="openHrSidebar()" class="text-[#002870] flex items-center">
            <span class="material-symbols-outlined" style="font-size:28px;">menu</span>
        </button>
    </div>

    <div class="p-6 lg:p-8 flex-grow">
        @yield('content')
    </div>
</main>

{{-- ═══════════════ MODAL TAMBAH LOWONGAN ═══════════════ --}}
<div id="vacancyModal"
     class="fixed inset-0 z-[999] items-center justify-center p-4"
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

                {{-- Row 1: Judul + Departemen --}}
                <div class="grid grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Judul Lowongan *</label>
                        <input type="text" name="title" required placeholder="cth: Frontend Developer"
                               class="h-11 px-4 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none
                                      focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                        <p class="modal-error text-red-500 text-xs hidden" data-field="title"></p>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Departemen *</label>
                        <input type="text" name="department" required placeholder="cth: Engineering"
                               class="h-11 px-4 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none
                                      focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                        <p class="modal-error text-red-500 text-xs hidden" data-field="department"></p>
                    </div>
                </div>

                {{-- Row 2: Lokasi + Tipe --}}
                <div class="grid grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Divisi *</label>
                        <input type="text" name="division" required placeholder="cth: Information Technology"
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
                                <option value="full-time">Full-time</option>
                                <option value="part-time">Part-time</option>
                                <option value="contract">Contract</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-400 pointer-events-none"
                                  style="font-size:18px;">expand_more</span>
                        </div>
                    </div>
                </div>

                {{-- Deadline --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Deadline *</label>
                    <input type="date" name="deadline" required
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="h-11 px-4 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none
                                  focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                </div>

                {{-- Deskripsi --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Deskripsi Pekerjaan *</label>
                    <textarea name="description" required rows="3"
                              placeholder="Jelaskan tanggung jawab dan lingkup pekerjaan..."
                              class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none resize-none
                                     focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all"></textarea>
                </div>

                {{-- Persyaratan --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-[#002870]">Persyaratan *</label>
                    <textarea name="requirements" required rows="3"
                              placeholder="Tuliskan kualifikasi dan persyaratan kandidat..."
                              class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm outline-none resize-none
                                     focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all"></textarea>
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

<script>
    /* ── Sidebar collapse (desktop) ── */
    let hrCollapsed = false;

    function setBlurOverlay(collapsed) {
        const overlay = document.getElementById('hrBlurOverlay');
        if (!overlay) return;
        if (collapsed) {
            overlay.classList.remove('active');
        } else {
            /* Only blur on desktop (lg+) */
            if (window.innerWidth >= 1024) overlay.classList.add('active');
        }
    }

    function toggleHrCollapse() {
        hrCollapsed = !hrCollapsed;
        document.getElementById('hrSidebar').classList.toggle('collapsed', hrCollapsed);
        document.getElementById('hrMain').classList.toggle('collapsed', hrCollapsed);
        setBlurOverlay(hrCollapsed);
        localStorage.setItem('hrSidebarCollapsed', hrCollapsed);
    }

    /* ── Mobile sidebar ── */
    function openHrSidebar() {
        document.getElementById('hrSidebar').style.transform = 'translateX(0)';
        document.getElementById('hrOverlay').classList.remove('hidden');
    }
    function closeHrSidebar() {
        document.getElementById('hrSidebar').style.transform = '';
        document.getElementById('hrOverlay').classList.add('hidden');
    }

    /* ── Restore collapse state & sync overlay ── */
    (function(){
        if(localStorage.getItem('hrSidebarCollapsed') === 'true') {
            hrCollapsed = true;
            document.getElementById('hrSidebar').classList.add('collapsed');
            document.getElementById('hrMain').classList.add('collapsed');
        }
        /* Apply overlay on load (desktop, expanded) */
        setBlurOverlay(hrCollapsed);
    })();

    /* Mobile: hide sidebar off-screen by default */
    if(window.innerWidth < 1024) {
        document.getElementById('hrSidebar').style.transform = 'translateX(-100%)';
        /* Remove overlay on mobile */
        const o = document.getElementById('hrBlurOverlay');
        if (o) o.classList.remove('active');
    }

    /* ── Vacancy Modal ── */
    function openVacancyModal() {
        document.getElementById('vacancyModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
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
