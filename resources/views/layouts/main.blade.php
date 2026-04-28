<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekrutmen — PT Nusantara Turbin dan Propulsi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @stack('styles')
</head>
<body>

    {{-- ================= PAGE LOADER ================= --}}
    <div id="page-loader">
        <div id="loader-sweep"></div>

        {{-- Turbin berputar --}}
        <div id="loader-turbine">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <g class="turbine-blade">
                    {{-- Blade 1 --}}
                    <ellipse cx="32" cy="14" rx="6" ry="13" fill="rgba(248,184,48,0.8)"/>
                    {{-- Blade 2 --}}
                    <ellipse cx="32" cy="14" rx="6" ry="13" fill="rgba(248,184,48,0.8)"
                        transform="rotate(120 32 32)"/>
                    {{-- Blade 3 --}}
                    <ellipse cx="32" cy="14" rx="6" ry="13" fill="rgba(248,184,48,0.8)"
                        transform="rotate(240 32 32)"/>
                </g>
                {{-- Hub tengah --}}
                <circle cx="32" cy="32" r="6" fill="rgba(255,255,255,0.95)"/>
                <circle cx="32" cy="32" r="3" fill="#002870"/>
            </svg>
        </div>

        <div id="loader-name">PT Nusantara Turbin dan Propulsi</div>
        <div id="loader-tag">Careers Portal</div>
    </div>

    {{-- ================= PAGE TRANSITION ================= --}}
    <div id="page-transition"></div>

    @if(!request()->routeIs('login', 'register'))
    {{-- ================= SIDEBAR ================= --}}
    <div id="sidebar" class="sidebar d-flex flex-column">

        {{-- Brand --}}
        <div class="sidebar-brand d-flex justify-content-between align-items-start">
            <div>
                <div class="sidebar-brand-name">PT. Nusantara Turbin dan Propulsi</div>
                <div class="sidebar-brand-tag">Careers Portal</div>
            </div>
            <button onclick="toggleSidebar()" class="sidebar-close">✕</button>
        </div>

        {{-- Navigation --}}
        <ul class="list-unstyled sidebar-menu">
            <li><a href="{{ route('home') }}" class="active"><i class="bi bi-house-door"></i> Beranda</a></li>
            <li><a href="#lowongan"><i class="bi bi-briefcase"></i> Lowongan</a></li>
            <li><a href="#proses"><i class="bi bi-diagram-3"></i> Proses Rekrutmen</a></li>
            <li><a href="#tentang"><i class="bi bi-building"></i> Tentang Kami</a></li>
            <li><a href="#kontak"><i class="bi bi-envelope"></i> Kontak</a></li>
        </ul>

        <div class="sidebar-divider"></div>

        {{-- Bottom Auth Section --}}
        <div class="sidebar-bottom mt-auto">
            @guest
                <div class="cta-box mb-3">
                    <small class="text-muted d-block mb-2">Belum punya akun?</small>
                    <a href="{{ route('register') }}" class="btn btn-secondary-custom w-100 btn-sm d-block text-center text-decoration-none" style="padding: 8px 16px; border-radius: 8px; font-size: 13px;">
                        Daftar Gratis
                    </a>
                </div>
                <a href="{{ route('login') }}" class="guest-box">
                    <i class="bi bi-person-circle"></i>
                    <div>
                        <strong>Guest</strong><br>
                        <small>Klik untuk masuk</small>
                    </div>
                </a>
            @endguest

            @auth
                <div class="cta-box mb-3 text-center">
                    <small class="text-muted d-block mb-2">Selamat datang,</small>
                    <strong>{{ Auth::user()->first_name }}</strong>
                    
                    @if(in_array(Auth::user()->role, ['hr', 'admin']))
                        <a href="{{ route('hr.dashboard') }}" class="btn w-100 mt-2 btn-sm d-block text-decoration-none" style="background: rgba(248,184,48,0.15); color: #f8b830; border: 1px solid rgba(248,184,48,0.2); border-radius: 8px; font-weight: 600; padding: 8px;">
                            <i class="bi bi-speedometer2 me-1"></i> Ke HR Panel
                        </a>
                    @endif
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="guest-box logout-box w-100">
                        <i class="bi bi-box-arrow-right"></i>
                        <div class="text-start">
                            <strong>Logout</strong><br>
                            <small>Keluar dari akun</small>
                        </div>
                    </button>
                </form>
            @endauth
        </div>

    </div>

    {{-- ================= TOGGLE ================= --}}
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

    {{-- ================= OVERLAY ================= --}}
    <div id="overlay" onclick="toggleSidebar()"></div>
    @endif

    {{-- ================= CONTENT ================= --}}
    <div id="main-content" class="page-enter">
        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- App JS --}}
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>