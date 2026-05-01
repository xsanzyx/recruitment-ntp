@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-name', 'Manajemen User')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        margin-top: 50px;
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

    .page-header-left .title {
        font-size: 28px;
        font-weight: 800;
        color: var(--text);
    }

    .dash-desc {
        font-size: 14px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /*MODALLLL*/
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: .15s;
        box-shadow: 0 2px 10px rgba(0, 40, 112, 0.25);
    }

    .btn-primary:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
    }

    .btn-primary svg {
        width: 16px;
        height: 16px;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-box {
        width: 520px;
        max-width: 95%;
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        animation: fadeIn .2s ease;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .modal-header h4 {
        font-weight: 700;
    }

    .modal-header button {
        border: none;
        background: none;
        font-size: 18px;
        cursor: pointer;
    }

    /* FORM */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 12px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    input,
    select {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-cancel {
        background: #eee;
        padding: 10px 18px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
    }

    .role-picker {
        display: flex;
        gap: 10px;
    }

    .role-option {
        flex: 1;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
        text-align: center;
    }

    .role-option input {
        display: none;
    }

    .role-option input:checked+span {
        font-weight: bold;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* FILTER BAR */
    .sub {
        font-size: 14px;
        color: var(--text-muted);
        margin-top: 10px;
        padding-left: 50px;
        padding-bottom: 5px;
    }

    .filter-bar {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 20px;
        padding-left: 50px;
        padding-right: 50px;
        flex-wrap: wrap;
    }

    .search-wrap {
        flex: 1;
        min-width: 260px;
        position: relative;
    }

    .search-wrap svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: var(--text-muted);
    }

    .search-wrap input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border: 1.5px solid var(--gray);
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: var(--text);
        background: var(--white);
        outline: none;
        transition: .15s;
    }

    .search-wrap input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 40, 112, 0.08);
    }

    .filter-select {
        padding: 10px 14px;
        border: 1.5px solid var(--gray);
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: var(--text);
        background: var(--white);
        outline: none;
        cursor: pointer;
        transition: .15s;
    }

    .filter-select:focus {
        border-color: var(--primary);
    }

    .btn-filter {
        padding: 10px 18px;
        border: 1.5px solid var(--primary);
        border-radius: var(--radius-sm);
        background: var(--primary-pale);
        color: var(--primary);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: .15s;
    }

    .btn-filter:hover {
        background: var(--primary);
        color: var(--white);
    }

    /* TABLE */
    .table-card {
        margin-left: 50px;
        margin-right: 50px;
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0, 40, 112, 0.06);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead th {
        padding: 14px 18px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: .05em;
        text-transform: uppercase;
        background: #f8f9fc;
        border-bottom: 1.5px solid var(--gray);
    }

    tbody tr {
        transition: .15s;
    }

    tbody tr:hover {
        background: #f8f9fc;
    }

    tbody td {
        padding: 14px 18px;
        border-bottom: 1px solid var(--gray);
        font-size: 14px;
        vertical-align: middle;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        flex-shrink: 0;
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

    .av-teal {
        background: #e0f5f3;
        color: #0f7a72;
    }

    .u-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
    }

    .u-email {
        font-size: 12px;
        color: var(--text-muted);
    }

    .badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-admin {
        background: #ede7f6;
        color: #5c3d99;
    }

    .badge-hr {
        background: var(--primary-pale);
        color: var(--primary);
    }

    .badge-kandidat {
        background: #e6f7f5;
        color: #0f7a72;
    }

    .badge-aktif {
        background: #e6f7f5;
        color: #0a6058;
        border: 1px solid #b3ede8;
    }

    .badge-pending {
        background: #fff8e8;
        color: #996600;
        border: 1px solid #f5d78e;
    }

    .badge-nonaktif {
        background: #fdecea;
        color: #b92b27;
        border: 1px solid #f9bdbb;
    }

    .date-cell {
        font-size: 13px;
        color: var(--text-muted);
    }

    .action-btns {
        display: flex;
        gap: 6px;
    }

    .modalEditUser {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modalEditUser.active {
        display: flex;
    }

    .form-card-edit {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0, 40, 112, 0.06);
        padding: 32px;
        max-width: 680px;
    }

    .form-card-title-edit {
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 4px;
    }

    .form-card-sub-edit {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 28px;
    }

    .divider-edit {
        height: 1px;
        background: var(--gray);
        margin-bottom: 24px;
    }

    .user-preview-edit {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px;
        background: #f8f9fc;
        border-radius: var(--radius-sm);
        margin-bottom: 24px;
        border: 1px solid var(--gray);
    }

    .up-avatar-edit {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        font-weight: 700;
        background: var(--primary-pale);
        color: var(--primary);
        flex-shrink: 0;
    }

    .up-info .name-edit {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
    }

    .up-info .email-edit {
        font-size: 13px;
        color: var(--text-muted);
    }

    .up-info .meta-edit {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .form-grid-edit {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group-edit {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full-edit {
        grid-column: 1/-1;
    }

    .form-label-edit {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .form-label-edit span {
        color: var(--danger);
        margin-left: 2px;
    }

    .form-input-edit,
    .form-select-edit {
        padding: 10px 14px;
        border: 1.5px solid var(--gray);
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: var(--text);
        background: var(--white);
        outline: none;
        transition: .15s;
        width: 100%;
    }

    .form-input-edit:focus,
    .form-select-edit:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 40, 112, 0.08);
    }

    .form-input-edit.is-invalid {
        border-color: var(--danger);
    }

    .error-msg-edit {
        font-size: 12px;
        color: var(--danger);
    }

    .form-hint {
        font-size: 12px;
        color: var(--text-muted);
    }

    .section-label-edit {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin: 24px 0 14px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--gray);
    }

    .role-picker-edit {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .role-option-edit {
        position: relative;
    }

    .role-option-edit input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .role-option-edit label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 14px 10px;
        border: 1.5px solid var(--gray);
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: .15s;
        text-align: center;
    }

    .role-option-edit label:hover {
        border-color: var(--primary);
        background: var(--primary-pale);
    }

    .role-option-edit input:checked+label {
        border-color: var(--primary);
        background: var(--primary-pale);
        box-shadow: 0 0 0 3px rgba(0, 40, 112, 0.08);
    }

    .role-icon-edit {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .role-icon-edit svg {
        width: 16px;
        height: 16px;
    }

    .ri-admin {
        background: #ede7f6;
        color: #5c3d99;
    }

    .ri-hr {
        background: var(--primary-pale);
        color: var(--primary);
    }

    .ri-user {
        background: #e6f7f5;
        color: #0f7a72;
    }

    .role-lbl-edit {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }

    .form-actions-edit {
        display: flex;
        gap: 12px;
        margin-top: 28px;
    }

    .btn-primary-edit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: .15s;
        box-shadow: 0 2px 10px rgba(0, 40, 112, 0.2);
    }

    .btn-primary-edit:hover {
        background: var(--primary-light);
    }

    .btn-cancel-edit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: transparent;
        color: var(--text-muted);
        border: 1.5px solid var(--gray);
        border-radius: var(--radius-sm);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: .15s;
    }

    .btn-cancel-edit:hover {
        border-color: var(--gray-dark);
        color: var(--text);
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: .15s;
        text-decoration: none;
    }

    .btn-icon svg {
        width: 15px;
        height: 15px;
    }

    .btn-edit {
        background: var(--primary-pale);
        color: var(--primary);
    }

    .btn-edit:hover {
        background: var(--primary);
        color: var(--white);
    }

    .btn-del {
        background: #fdecea;
        color: var(--danger);
    }

    .btn-del:hover {
        background: var(--danger);
        color: var(--white);
    }

    /* EMPTY */
    .empty-state {
        text-align: center;
        padding: 48px;
        color: var(--text-muted);
    }

    .empty-state svg {
        width: 48px;
        height: 48px;
        opacity: .3;
        margin-bottom: 12px;
    }

    .empty-state p {
        font-size: 14px;
    }

    /* PAGINATION */
    .pagination-wrap {
        padding: 16px 20px;
        border-top: 1px solid var(--gray);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-info {
        font-size: 13px;
        color: var(--text-muted);
    }

    .pagination {
        display: flex;
        gap: 4px;
    }

    .page-link {
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--gray);
        font-size: 13px;
        font-weight: 500;
        color: var(--text-muted);
        text-decoration: none;
        transition: .15s;
    }

    .page-link:hover,
    .page-link.active {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="dash-label">Admin Panel</div>
        <div class="title">Manajemen User</div>
        <div class="dash-desc">Kelola user, role, master data perusahaan, dan pantau aktivitas seluruh sistem.</div>
    </div>

    <button onclick="openModal()" class="btn-primary" style="margin-bottom:20px;">
        + Tambah User
    </button>
    {{-- ================= MODAL TAMBAH USER ================= --}}
    <div id="modalUser" class="modal-overlay">
        <div class="modal-box">

            <div class="modal-header">
                <h4>Tambah User Baru</h4>
                <button onclick="closeModal()">✕</button>
            </div>

            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">

                {{-- ROLE --}}
                <div class="form-group">
                    <label>Role</label>
                    <div class="role-picker">
                        <label class="role-option">
                            <input type="radio" name="role" value="admin">
                            <span>Admin</span>
                        </label>

                        <label class="role-option">
                            <input type="radio" name="role" value="hr" checked>
                            <span>HR</span>
                        </label>

                        <label class="role-option">
                            <input type="radio" name="role" value="user">
                            <span>Kandidat</span>
                        </label>
                    </div>
                </div>

                {{-- INPUT --}}
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" id="nameInput" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="emailInput" required>
                </div>

                <div class="form-row">
                    <div>
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <div>
                        <label>Konfirmasi</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="statusInput">
                        <option value=" active">Aktif</option>
                        <option value="pending">Pending</option>
                        <option value="nonactive">Nonaktif</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Simpan</button>
                    <button type="button" onclick="closeModal()" class="btn-cancel">Batal</button>
                </div>
            </form>

        </div>
    </div>

</div>

{{-- FILTER --}}
<form method="GET" action="{{ route('admin.users.index') }}">
    <div class="sub">{{ $users->total() }} dari {{ $total }} user</div>
    <div class="filter-bar">
        <div class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}">
        </div>
        <select name="role" class="filter-select">
            <option value="semua" {{ request('role','semua') === 'semua' ? 'selected' : '' }}>Semua role</option>
            <option value="admin" {{ request('role') === 'admin'  ? 'selected' : '' }}>Admin</option>
            <option value="hr" {{ request('role') === 'hr'     ? 'selected' : '' }}>HR</option>
            <option value="user" {{ request('role') === 'user'   ? 'selected' : '' }}>Kandidat</option>
        </select>
        <select name="status" class="filter-select">
            <option value="semua" {{ request('status','semua') === 'semua'     ? 'selected' : '' }}>Semua status</option>
            <option value="active" {{ request('status') === 'active'    ? 'selected' : '' }}>Aktif</option>
            <option value="pending" {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
            <option value="nonactive" {{ request('status') === 'nonactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <button type="submit" class="btn-filter">Cari</button>
    </div>
</form>

{{-- TABLE --}}
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Role</th>
                <th>Status</th>
                <th>Bergabung</th>
                <th>Aktif Terakhir</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            @php
            $avList = ['av-red','av-blue','av-green','av-yellow','av-purple','av-orange','av-teal'];
            $av = $avList[crc32($user->email) % count($avList)];
            $statusClass = match($user->status) {
            'active' => 'badge-aktif',
            'pending' => 'badge-pending',
            'nonactive' => 'badge-nonaktif',
            default => 'badge-pending'
            };
            $roleClass = match($user->role) {
            'admin' => 'badge-admin',
            'hr' => 'badge-hr',
            default => 'badge-kandidat'
            };
            @endphp
            <tr>
                <td>
                    <div class="user-cell">
                        <div class="avatar {{ $av }}">{{ $user->initial }}</div>
                        <div>
                            <div class="u-name">{{ $user->first_name }} {{ $user->last_name }}</div>
                            <div class="u-email">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge {{ $roleClass }}">{{ $user->role_label }}</span></td>
                <td><span class="badge {{ $statusClass }}">{{ $user->status_label }}</span></td>
                <td class="date-cell">{{ $user->created_at->format('Y-m-d') }}</td>
                <td class="date-cell">{{ $user->last_active_at ? $user->last_active_at->format('Y-m-d') : '-' }}</td>
                <td>
                    <div class="action-btns" style="justify-content:flex-end;">
                        <button onclick="openEditModal()" class="btn-icon btn-edit" title="edit" button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </button>
                        <div id="modalEditUser" class="modal-overlay">
                            <div class="form-card-edit">

                                <div class="form-card-title-edit">Edit User</div>
                                <div class="form-card-sub-edit">Perbarui data akun dan role user.</div>
                                <div class="divider-edit"></div>

                                <div class="user-preview-edit">
                                    <div class="up-avatar-edit" id="editAvatar"></div>
                                    <div class="up-info-edit">
                                        <div class="name-edit" id="editNamePreview"></div>
                                        <div class="email-edit" id="editEmailPreview"></div>
                                        <div class="meta-edit" id="editMeta"></div>
                                    </div>
                                </div>

                                <form id="editForm" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">

                                    {{-- ROLE --}}
                                    <div class="form-group-edit" style="margin-bottom:20px;">
                                        <div class="form-label-edit">Role <span>*</span></div>

                                        <div class="role-picker-edit">
                                            <div class="role-option-edit">
                                                <input type="radio" name="role" value="admin">
                                                <label>Admin</label>
                                            </div>

                                            <div class="role-option-edit">
                                                <input type="radio" name="role" value="hr">
                                                <label>HR</label>
                                            </div>

                                            <div class="role-option-edit">
                                                <input type="radio" name="role" value="user">
                                                <label>Kandidat</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-grid-edit">
                                        <div class="form-group full-edit">
                                            <label>Nama</label>
                                            <input type="text" id="editName" name="name" class="form-input-edit">
                                        </div>

                                        <div class="form-group full-edit">
                                            <label>Email</label>
                                            <input type="email" id="editEmail" name="email" class="form-input-edit">
                                        </div>

                                        <div class="form-group full-edit">
                                            <label>Status</label>
                                            <select id="editStatus" name="status" class="form-select-edit">
                                                <option value="active">Aktif</option>
                                                <option value="pending">Pending</option>
                                                <option value="nonactive">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-actions-edit">
                                        <button type="submit" class="btn-primary-edit">Simpan</button>
                                        <button type="button" onclick="closeEditModal()" class="btn-cancel-edit">Batal</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-del" title="Hapus">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <p>Tidak ada user ditemukan.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($users->hasPages())
    <div class="pagination-wrap">
        <div class="pagination-info">Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} user</div>
        <div class="pagination">
            @foreach($users->links()->elements[0] as $page => $url)
            <a href="{{ $url }}" class="page-link {{ $users->currentPage() == $page ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function openModal() {
        document.getElementById('modalUser').classList.add('active');

        const form = document.getElementById('userForm');

        form.action = "/admin/users";
        document.getElementById('methodField').value = "POST";

        form.reset();

        document.querySelector('[name=role][value="hr"]').checked = true;
    }

    function closeModal() {
        document.getElementById('modalUser').classList.remove('active');
    }

    function openEditModal(id, name, email, role, status) {

        document.getElementById('modalEditUser').classList.add('active');

        // set action
        document.getElementById('editForm').action = `/admin/users/${id}`;

        // isi input
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editStatus').value = status;

        // role
        document.querySelectorAll('#modalEditUser [name=role]').forEach(r => {
            r.checked = r.value === role;
        });

        // preview
        document.getElementById('editNamePreview').innerText = name;
        document.getElementById('editEmailPreview').innerText = email;
    }

    function closeEditModal() {
        document.getElementById('modalEditUser').classList.remove('active');
    }

    document.getElementById('modalUser').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") closeModal();
    });
</script>
@endpush