<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') – Recruitment NTP</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #002870;
            --primary-light: #003a9e;
            --primary-pale: #e8edf8;
            --secondary: #f8b830;
            --secondary-light: #ffd166;
            --gray: #e9edf1;
            --gray-mid: #c5cdd8;
            --gray-dark: #6b7a8d;
            --text: #0d1b2e;
            --text-muted: #6b7a8d;
            --white: #ffffff;
            --danger: #e63946;
            --success: #2ec4b6;
            --pending-color: #f8b830;
            --radius: 14px;
            --radius-sm: 8px;
            --shadow: 0 2px 16px rgba(0, 40, 112, 0.08);
            --shadow-md: 0 4px 24px rgba(0, 40, 112, 0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f3f5f9;
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background: var(--primary);
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(0, 40, 112, 0.18);
        }

        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--secondary);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            width: 20px;
            height: 20px;
        }

        .logo-text {
            font-size: 15px;
            font-weight: 800;
            color: var(--white);
            line-height: 1.2;
        }

        .logo-sub {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.45);
            font-weight: 500;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .sidebar-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.3);
            padding: 20px 24px 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            margin: 2px 12px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all .18s;
            color: rgba(255, 255, 255, 0.6);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: var(--white);
        }

        .nav-item.active {
            background: rgba(248, 184, 48, 0.18);
            color: var(--secondary);
            border-left: 3px solid var(--secondary);
        }

        .nav-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background: var(--secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--primary);
        }

        .user-info .name {
            font-size: 13px;
            font-weight: 600;
            color: var(--white);
        }

        .user-info .role-tag {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.45);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            margin: 4px 0 0;
            border-radius: var(--radius-sm);
            color: rgba(255, 255, 255, 0.5);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: .15s;
        }

        .btn-logout:hover {
            background: rgba(230, 57, 70, 0.15);
            color: #e63946;
        }

        /* MAIN */
        .main {
            margin-left: 240px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ALERTS */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
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

        .alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-badge">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#002870" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg>
                </div>
                <div>
                    <div class="logo-text">Recruitment</div>
                    <div class="logo-sub">NTP System</div>
                </div>
            </div>
        </div>

        <div class="sidebar-label">Menu Utama</div>

        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" />
                <rect x="14" y="3" width="7" height="7" />
                <rect x="14" y="14" width="7" height="7" />
                <rect x="3" y="14" width="7" height="7" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            Manajemen User
        </a>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="name">{{ auth()->user()->name }}</div>
                    <div class="role-tag">Administrator</div>
                </div>
            </div>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn-logout">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="main">
        <main class="content">
            @if(session('success'))
            <div class="alert alert-success">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>