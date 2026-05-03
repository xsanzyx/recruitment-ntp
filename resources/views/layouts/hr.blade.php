<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HR Panel') — PT Nusantara Turbin dan Propulsi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- Shared base styles (same as public site) --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- HR-specific overrides --}}
    <link rel="stylesheet" href="{{ asset('css/hr-panel.css') }}">

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    @stack('styles')
</head>

<body>

    {{-- ================= SIDEBAR (same style as public) ================= --}}
    <div id="sidebar" class="sidebar d-flex flex-column">

        <div class="sidebar-brand d-flex justify-content-between align-items-start">
            <div>
                <div class="sidebar-brand-name">PT. Nusantara Turbin dan Propulsi</div>
                <div class="sidebar-brand-tag">HR Panel</div>
            </div>
            <button onclick="toggleSidebar()" class="sidebar-close">✕</button>
        </div>

        <ul class="list-unstyled sidebar-menu">
            <li>
                <a href="{{ route('hr.dashboard') }}" class="{{ request()->routeIs('hr.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('hr.vacancies.index') }}" class="{{ request()->routeIs('hr.vacancies.*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase-fill"></i> Lowongan
                </a>
            </li>
            <li>
                <a href="{{ route('hr.applications.index') }}" class="{{ request()->routeIs('hr.applications.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Kandidat
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>

        <ul class="list-unstyled sidebar-menu" style="flex:0;">
            <li>
                <a href="{{ route('home') }}">
                    <i class="bi bi-house-door"></i> Beranda Publik
                </a>
            </li>
        </ul>

        <div class="sidebar-bottom mt-auto">
            <div class="cta-box mb-3 text-center">
                <small class="text-muted d-block mb-2">Selamat datang,</small>
                <strong>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong>
                <small class="d-block mt-1" style="color:#94a3b8;font-size:11px;">Human Resources</small>
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
        </div>
    </div>

    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <div id="overlay" onclick="toggleSidebar()"></div>

    {{-- ================= MAIN ================= --}}
    <main class="hr-main" id="hrMain">

        {{-- Top Bar --}}
        <header class="hr-topbar">
            <div class="hr-topbar-left">
                <div>
                    <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
                    <small class="text-muted">@yield('page-subtitle', 'Selamat datang di panel HR')</small>
                </div>
            </div>
            <div class="hr-topbar-right">
                <span class="hr-topbar-date">
                    <i class="bi bi-calendar3"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Page Content --}}
        <div class="hr-content">
            @yield('content')
        </div>

    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Sidebar toggle (same as public site) --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Auto-dismiss alerts --}}
    <script>
        document.querySelectorAll('.alert-dismissible').forEach(alert => {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 4000);
        });
    </script>

    @stack('scripts')
</body>

</html>