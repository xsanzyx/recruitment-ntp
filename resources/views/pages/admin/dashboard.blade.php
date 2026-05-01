@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-name', 'Dashboard')

@push('styles')
<style>
    .dash-header {
        margin-top: 50px;
        margin-bottom: 28px;
        padding-left: 50px;
        padding-right: 50px;
    }

    .dash-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--primary);
        opacity: .7;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .dash-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--text);
        line-height: 1.2;
    }

    .dash-desc {
        font-size: 14px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* STAT CARDS */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
        padding-left: 50px;
        padding-right: 50px;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 22px 24px;
        box-shadow: var(--shadow);
        border: 1px solid rgba(0, 40, 112, 0.06);
        position: relative;
        overflow: hidden;
        transition: .2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-card:nth-child(1)::after {
        background: var(--primary);
    }

    .stat-card:nth-child(2)::after {
        background: #5c6bc0;
    }

    .stat-card:nth-child(3)::after {
        background: var(--success);
    }

    .stat-card:nth-child(4)::after {
        background: var(--secondary);
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }

    .stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .stat-icon.blue {
        background: var(--primary-pale);
    }

    .stat-icon.blue svg {
        color: var(--primary);
    }

    .stat-icon.indigo {
        background: #ede7f6;
    }

    .stat-icon.indigo svg {
        color: #5c6bc0;
    }

    .stat-icon.green {
        background: #e0f7f5;
    }

    .stat-icon.green svg {
        color: var(--success);
    }

    .stat-icon.yellow {
        background: #fff8e8;
    }

    .stat-icon.yellow svg {
        color: #c8890a;
    }

    .stat-num {
        font-size: 32px;
        font-weight: 800;
        color: var(--text);
        line-height: 1;
    }

    .stat-lbl {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
        font-weight: 500;
    }

    /* BOTTOM GRID */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1.6fr;
        gap: 16px;
        padding-left: 50px;
        padding-right: 50px;
    }

    .card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow);
        border: 1px solid rgba(0, 40, 112, 0.06);
    }

    .card-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 4px;
    }

    .card-sub {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 20px;
    }

    /* DISTRIBUSI */
    .role-row {
        margin-bottom: 14px;
    }

    .role-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .role-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .role-count {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-muted);
    }

    .progress-track {
        height: 7px;
        background: var(--gray);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width .6s ease;
    }

    .fill-admin {
        background: var(--primary);
    }

    .fill-hr {
        background: #5c6bc0;
    }

    .fill-kandidat {
        background: var(--success);
    }

    .stat-mini-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 20px;
    }

    .stat-mini {
        background: var(--gray);
        border-radius: var(--radius-sm);
        padding: 14px 16px;
    }

    .stat-mini .lbl {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stat-mini .lbl svg {
        width: 14px;
        height: 14px;
    }

    .stat-mini .val {
        font-size: 24px;
        font-weight: 800;
        color: var(--text);
    }

    /* USER TERBARU */
    .user-list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .btn-kelola {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--gray);
        background: transparent;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        text-decoration: none;
        transition: .15s;
    }

    .btn-kelola:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .btn-kelola svg {
        width: 14px;
        height: 14px;
    }

    .user-row {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--gray);
    }

    .user-row:last-child {
        border-bottom: none;
    }

    .avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
        margin-right: 12px;
    }

    .av-red {
        background: #ffe0e0;
        color: #c0392b;
    }

    .av-blue {
        background: #e0eaff;
        color: #2244aa;
    }

    .av-green {
        background: #e0f5ee;
        color: #1a7a5e;
    }

    .av-yellow {
        background: #fff3d0;
        color: #996600;
    }

    .av-purple {
        background: #ede7f6;
        color: #5c3d99;
    }

    .av-orange {
        background: #ffeacc;
        color: #c06000;
    }

    .user-info-col {
        flex: 1;
    }

    .user-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
    }

    .user-email {
        font-size: 12px;
        color: var(--text-muted);
    }

    .badges {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    .badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-kandidat {
        background: #e6f7f5;
        color: #0f7a72;
    }

    .badge-hr {
        background: var(--primary-pale);
        color: var(--primary);
    }

    .badge-admin {
        background: #ede7f6;
        color: #5c3d99;
    }

    .badge-aktif {
        background: #e6f7f5;
        color: #0a6058;
    }

    .badge-pending {
        background: #fff8e8;
        color: #996600;
    }

    .badge-nonaktif {
        background: #fdecea;
        color: #b92b27;
    }

    .total-note {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 14px;
    }

    .total-note strong {
        color: var(--text);
    }
</style>
@endpush

@section('content')
<div class="dash-header">
    <div class="dash-label">Admin Panel</div>
    <div class="dash-title">Administrasi Sistem</div>
    <div class="dash-desc">Kelola user, role, master data perusahaan, dan pantau aktivitas seluruh sistem.</div>
</div>

{{-- STAT CARDS --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
        </div>
        <div class="stat-num">{{ $stats['total_user'] }}</div>
        <div class="stat-lbl">Total User</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon indigo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <line x1="19" y1="8" x2="23" y2="8" />
                <line x1="19" y1="11" x2="23" y2="11" />
            </svg>
        </div>
        <div class="stat-num">{{ $stats['total_hr_admin'] }}</div>
        <div class="stat-lbl">HR & Admin</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
        </div>
        <div class="stat-num">{{ $stats['total_kandidat'] }}</div>
        <div class="stat-lbl">Kandidat</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
            </svg>
        </div>
        <div class="stat-num">{{ $stats['lowongan_aktif'] }}</div>
        <div class="stat-lbl">Lowongan Aktif</div>
    </div>
</div>

{{-- BOTTOM --}}
<div class="bottom-grid">
    {{-- DISTRIBUSI ROLE --}}
    <div class="card">
        <div class="card-title">Distribusi Role</div>
        <div class="card-sub">Sebaran user berdasarkan role.</div>

        @php
        $total = $distribusi['admin'] + $distribusi['hr'] + $distribusi['kandidat'];
        $pctAdmin = $total ? round($distribusi['admin'] / $total * 100) : 0;
        $pctHr = $total ? round($distribusi['hr'] / $total * 100) : 0;
        $pctKandidat = $total ? round($distribusi['kandidat'] / $total * 100) : 0;
        @endphp

        <div class="role-row">
            <div class="role-header"><span class="role-name">Admin</span><span class="role-count">{{ $distribusi['admin'] }}</span></div>
            <div class="progress-track">
                <div class="progress-fill fill-admin" style="width:{{ $pctAdmin }}%"></div>
            </div>
        </div>
        <div class="role-row">
            <div class="role-header"><span class="role-name">HR</span><span class="role-count">{{ $distribusi['hr'] }}</span></div>
            <div class="progress-track">
                <div class="progress-fill fill-hr" style="width:{{ $pctHr }}%"></div>
            </div>
        </div>
        <div class="role-row">
            <div class="role-header"><span class="role-name">Kandidat</span><span class="role-count">{{ $distribusi['kandidat'] }}</span></div>
            <div class="progress-track">
                <div class="progress-fill fill-kandidat" style="width:{{ $pctKandidat }}%"></div>
            </div>
        </div>

        <div class="stat-mini-grid">
            <div class="stat-mini">
                <div class="lbl">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#2ec4b6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    User Aktif
                </div>
                <div class="val">{{ $user_aktif }}</div>
            </div>
            <div class="stat-mini">
                <div class="lbl">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#f8b830" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    Pending
                </div>
                <div class="val">{{ $user_pending }}</div>
            </div>
        </div>
    </div>

    {{-- USER TERBARU --}}
    <div class="card">
        <div class="user-list-header">
            <div>
                <div class="card-title">User Terbaru</div>
                <div class="card-sub">Pendaftar terakhir di sistem.</div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn-kelola">
                Kelola
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                </svg>
            </a>
        </div>

        @php
        $avColors = ['av-red','av-blue','av-green','av-yellow','av-purple','av-orange'];
        @endphp

        @foreach($user_terbaru as $i => $u)
        <div class="user-row">
            <div class="avatar {{ $avColors[$i % count($avColors)] }}">{{ $u->initial }}</div>
            <div class="user-info-col">
                <div class="user-name">{{ $u->name }}</div>
                <div class="user-email">{{ $u->email }}</div>
            </div>
            <div class="badges">
                <span class="badge badge-kandidat">{{ $u->role_label }}</span>
                <span class="badge badge-{{ $u->status === 'active' ? 'aktif' : ($u->status === 'pending' ? 'pending' : 'nonaktif') }}">
                    {{ $u->status_label }}
                </span>
            </div>
        </div>
        @endforeach

        <div class="total-note">Total kandidat tercatat: <strong>{{ $stats['total_kandidat'] }}</strong></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchTab(name, el) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
    }
</script>
@endpush