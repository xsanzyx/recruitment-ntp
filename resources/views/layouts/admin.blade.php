<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Admin Panel') — NTP Careers</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- Tailwind (same as HR layout, but disable preflight to protect custom CSS) --}}
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false,
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Shared Sidebar CSS (same as HR & Guest) --}}
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: #f3f5f9;
            color: #0d1b2e;
            min-height: 100vh;
        }

        /* Override toggle btn z-index */
        .toggle-btn { z-index: 998; }

        /* Main content padding */
        #adminMain { padding-top: 60px; }
        @media(min-width: 1024px) {
            #adminMain { padding-top: 20px; }
            .toggle-btn { top: 20px; left: 20px; }
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #e6f9f7;
            color: #0f7a72;
            border: 1px solid #b3ede8;
        }

        .alert-error {
            background: #fdecea;
            color: #b92b27;
            border: 1px solid #f9bdbb;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased min-h-screen">

{{-- ═══════════════ SIDEBAR (SAME AS HR/PUBLIC) ═══════════════ --}}
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

    <div class="sidebar-bottom mt-auto">
        <div class="cta-box mb-3 text-center">
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
        @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle" style="font-size:18px;"></i>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">
            <i class="bi bi-exclamation-circle" style="font-size:18px;"></i>
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>