@php
    use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekrutmen — PT Nusantara Turbin dan Propulsi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>

    {{-- ================= PAGE LOADER ================= --}}
    <div id="page-loader">
        <div id="loader-sweep"></div>
        <div id="loader-turbine">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <g class="turbine-blade">
                    <ellipse cx="32" cy="14" rx="6" ry="13" fill="rgba(248,184,48,0.8)"/>
                    <ellipse cx="32" cy="14" rx="6" ry="13" fill="rgba(248,184,48,0.8)" transform="rotate(120 32 32)"/>
                    <ellipse cx="32" cy="14" rx="6" ry="13" fill="rgba(248,184,48,0.8)" transform="rotate(240 32 32)"/>
                </g>
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

        <div class="sidebar-brand d-flex justify-content-between align-items-start">
            <div>
                <div class="sidebar-brand-name">PT. Nusantara Turbin dan Propulsi</div>
                <div class="sidebar-brand-tag">Careers Portal</div>
            </div>
            <button onclick="toggleSidebar()" class="sidebar-close">✕</button>
        </div>

        <ul class="list-unstyled sidebar-menu">
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('lowongan') }}" class="{{ request()->routeIs('lowongan') ? 'active' : '' }}">
                    <i class="bi bi-briefcase"></i> Lowongan
                </a>
            </li>
            <li>
                <a href="{{ route('proses-rekrutmen') }}" class="{{ request()->routeIs('proses-rekrutmen') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i> Proses Rekrutmen
                </a>
            </li>
            <li>
                <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Tentang Kami
                </a>
            </li>
            <li>
                <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">
                    <i class="bi bi-envelope"></i> Kontak
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>

        <div class="sidebar-bottom mt-auto">
            @guest
                <div class="cta-box mb-3">
                    <small class="text-muted d-block mb-2">Belum punya akun?</small>
                    <a href="{{ route('register') }}" class="btn btn-secondary-custom w-100 btn-sm d-block text-center text-decoration-none" style="padding:8px 16px;border-radius:8px;font-size:13px;">
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

        <small class="text-muted d-block mb-1">Selamat datang,</small>
        <strong style="font-size:14px;color:var(--primary-color);">
            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
        </strong>

        <a href="{{ route('profile') }}" class="btn w-100 mt-2 btn-sm d-block text-decoration-none"
           style="background:rgba(0,40,112,0.06);color:var(--primary-color);border:1px solid rgba(0,40,112,0.12);border-radius:8px;font-weight:600;padding:7px;font-size:12px;">
            <i class="bi bi-person-gear me-1"></i> Edit Profil
        </a>

        @if(in_array(Auth::user()->role, ['hr', 'admin']))
            <a href="{{ route('hr.dashboard') }}" class="btn w-100 mt-2 btn-sm d-block text-decoration-none"
               style="background:rgba(248,184,48,0.15);color:#f8b830;border:1px solid rgba(248,184,48,0.2);border-radius:8px;font-weight:600;padding:8px;">
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

    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <div id="overlay" onclick="toggleSidebar()"></div>
    @endif

    <div id="main-content" class="page-enter">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>