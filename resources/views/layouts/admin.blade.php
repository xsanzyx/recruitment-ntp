<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Admin Panel') — NTP Careers</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 1. Tailwind CSS (SAME config as HR layout) --}}
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

    {{-- 2. Icons & Fonts (SAME as HR layout) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- 3. Base & Layout CSS (for exact sidebar styling — SAME as HR) --}}
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

    <style>
        body { font-family: 'Inter', sans-serif; background: #f6fafe; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f6fafe; }
        ::-webkit-scrollbar-thumb { background: #dfe3e7; border-radius: 4px; }

        /* MODAL */
        .admin-modal { display: none; }
        .admin-modal.open { display: flex; }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(.96) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .admin-modal-card { animation: modalIn .25s cubic-bezier(.22,1,.36,1) both; }

        /* OVERRIDE TOGGLE BTN Z-INDEX */
        .toggle-btn { z-index: 998; }

        /* Main content padding so it doesn't hide behind toggle button */
        #adminMain { padding-top: 60px; }
        @media(min-width: 1024px) {
            #adminMain { padding-top: 20px; }
            .toggle-btn { top: 20px; left: 20px; }
        }

        /* Fix double arrows on select elements */
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

{{-- ═══════════════ SIDEBAR (EXACTLY SAME AS HR) ═══════════════ --}}
<div id="sidebar" class="sidebar flex flex-col z-[1000]">

    <div class="sidebar-brand flex justify-between items-start">
        <div>
            <div class="sidebar-brand-name">PT. Nusantara Turbin dan Propulsi</div>
            <div class="sidebar-brand-tag">ADMIN PANEL</div>
        </div>
        <button onclick="toggleSidebar()" class="sidebar-close flex items-center justify-center">✕</button>
    </div>

    {{-- Admin Menu --}}
    <ul class="sidebar-menu list-none p-0" style="flex:0;">
        <li class="mb-[1px]">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard Admin
            </a>
        </li>
        <li class="mb-[1px]">
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Manajemen User
            </a>
        </li>
    </ul>

    <div class="sidebar-divider"></div>

    {{-- HR Panel Access (Admin bisa akses HR) --}}
    <ul class="sidebar-menu list-none p-0" style="flex:0;">
        <li class="mb-[1px]">
            <a href="{{ route('hr.dashboard') }}">
                <i class="bi bi-briefcase"></i> Panel HR
            </a>
        </li>
    </ul>

    <div class="sidebar-divider"></div>

    {{-- Public Links --}}
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
            <a href="{{ route('profile') }}" style="text-decoration:none;">
                <div style="width:56px;height:56px;border-radius:50%;overflow:hidden;border:2px solid rgba(0,40,112,0.15);margin:0 auto 10px;cursor:pointer;">
                    @if(Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div style="width:100%;height:100%;background:rgba(0,40,112,0.06);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-person-fill" style="font-size:26px;color:var(--primary-color);"></i>
                        </div>
                    @endif
                </div>
            </a>

            <small class="text-[#94a3b8] block mb-2" style="font-size:11px;">Selamat datang,</small>
            <strong style="color:var(--primary-color);font-size:14px;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong>
            <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Administrator</div>
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
<main id="adminMain" class="min-h-screen flex flex-col transition-all lg:ml-16">
    <div class="p-6 lg:p-8 flex-grow">
        @yield('content')
    </div>
</main>

{{-- Success / Error flash (SAME style as HR) --}}
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
@stack('scripts')
</body>
</html>