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

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    {{-- HR CSS --}}
    <link rel="stylesheet" href="{{ asset('css/hr-panel.css') }}">

    @stack('styles')
</head>
<body>

    {{-- ================= SIDEBAR ================= --}}
    <aside class="hr-sidebar" id="hrSidebar">

        {{-- Brand --}}
        <div class="hr-sidebar-brand">
            <div class="hr-brand-icon">
                <i class="bi bi-gear-wide-connected"></i>
            </div>
            <div>
                <h6>NTP Careers</h6>
                <small>HR Panel</small>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="hr-sidebar-nav">
            <div class="hr-nav-section">MENU UTAMA</div>

            <a href="{{ route('hr.dashboard') }}"
               class="hr-nav-link {{ request()->routeIs('hr.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('hr.vacancies.index') }}"
               class="hr-nav-link {{ request()->routeIs('hr.vacancies.*') ? 'active' : '' }}">
                <i class="bi bi-briefcase-fill"></i>
                <span>Lowongan</span>
            </a>

            <a href="{{ route('hr.applications.index') }}"
               class="hr-nav-link {{ request()->routeIs('hr.applications.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Kandidat</span>
            </a>

            <div class="hr-nav-section mt-4">LAINNYA</div>

            <a href="{{ route('home') }}" class="hr-nav-link">
                <i class="bi bi-house-fill"></i>
                <span>Beranda Publik</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                @csrf
                <button type="submit" class="hr-nav-link hr-nav-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>

        {{-- User Info --}}
        <div class="hr-sidebar-user">
            <div class="hr-user-avatar">
                {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
            </div>
            <div>
                <strong>{{ Auth::user()->full_name }}</strong>
                <small>Human Resources</small>
            </div>
        </div>

    </aside>

    {{-- ================= MAIN ================= --}}
    <main class="hr-main" id="hrMain">

        {{-- Top Bar --}}
        <header class="hr-topbar">
            <div class="hr-topbar-left">
                <button class="hr-sidebar-toggle" id="hrSidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
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

    {{-- ================= OVERLAY (mobile) ================= --}}
    <div class="hr-overlay" id="hrOverlay"></div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Sidebar Toggle Script --}}
    <script>
        const sidebar = document.getElementById('hrSidebar');
        const mainContent = document.getElementById('hrMain');
        const overlay = document.getElementById('hrOverlay');
        const toggle = document.getElementById('hrSidebarToggle');

        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
            overlay.classList.remove('active');
        });

        // Auto-dismiss alerts after 4 seconds
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
