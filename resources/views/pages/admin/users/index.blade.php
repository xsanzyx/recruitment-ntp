@extends('layouts.admin')

@section('title', 'Manajemen User')
@section('page-name', 'Manajemen User')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-panel.css') }}">
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="dash-label">Admin Panel</div>
        <div class="title">Manajemen User</div>
        <div class="dash-desc">Kelola user, role, master data perusahaan, dan pantau aktivitas seluruh sistem.</div>
    </div>

    <button onclick="openCreateModal()" class="btn-primary" style="margin-bottom:20px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah User
    </button>
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
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            @php
            $avList = ['av-red','av-blue','av-green','av-yellow','av-purple','av-orange','av-teal'];
            $av = $avList[crc32($user->email) % count($avList)];
            $statusClass = match($user->status) {
                'active'    => 'badge-aktif',
                'pending'   => 'badge-pending',
                'nonactive' => 'badge-nonaktif',
                default     => 'badge-pending'
            };
            $roleClass = match($user->role) {
                'admin' => 'badge-admin',
                'hr'    => 'badge-hr',
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
                <td>
                    <div class="action-btns" style="justify-content:flex-end;">
                        {{-- Edit Button --}}
                        <button onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->first_name) }}', '{{ addslashes($user->last_name) }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->status }}')" class="btn-icon btn-edit" title="Edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </button>

                        {{-- Delete Button --}}
                        @if($user->id !== auth()->id())
                        <button onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->first_name) }} {{ addslashes($user->last_name) }}')" class="btn-icon btn-del" title="Hapus">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                <path d="M10 11v6" />
                                <path d="M14 11v6" />
                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                            </svg>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
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

{{-- ================= MODAL: TAMBAH USER (Global, outside loop) ================= --}}
<div id="modalCreateUser" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h4>Tambah User Baru</h4>
            <button onclick="closeCreateModal()">✕</button>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any() && old('_create_form'))
        <div style="background:#fdecea; border:1px solid #f9bdbb; border-radius:8px; padding:12px 16px; margin-bottom:16px;">
            <div style="font-size:13px; font-weight:600; color:#b92b27; margin-bottom:6px;">Terjadi kesalahan:</div>
            <ul style="margin:0; padding-left:18px; font-size:13px; color:#b92b27;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="createForm" method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <input type="hidden" name="_create_form" value="1">

            {{-- ROLE --}}
            <div class="form-group">
                <label>Role <span>*</span></label>
                <div class="role-picker">
                    <div class="role-option">
                        <input type="radio" name="role" value="admin" id="createRoleAdmin" {{ old('role') == 'admin' ? 'checked' : '' }}>
                        <label for="createRoleAdmin">
                            <div class="role-icon ri-admin">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                            </div>
                            Admin
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" name="role" value="hr" id="createRoleHR" {{ old('role', 'hr') == 'hr' ? 'checked' : '' }}>
                        <label for="createRoleHR">
                            <div class="role-icon ri-hr">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            HR
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" name="role" value="kandidat" id="createRoleUser" {{ old('role') == 'kandidat' ? 'checked' : '' }}>
                        <label for="createRoleUser">
                            <div class="role-icon ri-user">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            Kandidat
                        </label>
                    </div>
                </div>
            </div>

            {{-- NAME --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Depan <span>*</span></label>
                    <input type="text" name="first_name" required placeholder="Nama depan" value="{{ old('first_name') }}">
                </div>
                <div class="form-group">
                    <label>Nama Belakang</label>
                    <input type="text" name="last_name" placeholder="Nama belakang" value="{{ old('last_name') }}">
                </div>
            </div>

            {{-- EMAIL --}}
            <div class="form-group">
                <label>Email <span>*</span></label>
                <input type="email" name="email" required placeholder="email@contoh.com" value="{{ old('email') }}">
            </div>

            {{-- PASSWORD --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Password <span>*</span></label>
                    <input type="password" name="password" id="createPassword" required placeholder="Min. 8 karakter">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password <span>*</span></label>
                    <input type="password" name="password_confirmation" id="createPasswordConfirm" required placeholder="Ulangi password">
                </div>
            </div>
            <div id="createPasswordError" style="display:none; font-size:12px; color:var(--danger); margin-top:-8px; margin-bottom:12px;"></div>

            <div style="font-size:12px; color:var(--text-muted); margin-bottom:4px;">Status user yang dibuat oleh Admin akan otomatis <strong>Aktif</strong>.</div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Simpan</button>
                <button type="button" onclick="closeCreateModal()" class="btn-cancel">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL: EDIT USER (Global, outside loop) ================= --}}
<div id="modalEditUser" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h4>Edit User</h4>
            <button onclick="closeEditModal()">✕</button>
        </div>

        {{-- Validation Errors --}}
        @if($errors->any() && old('_edit_form'))
        <div style="background:#fdecea; border:1px solid #f9bdbb; border-radius:8px; padding:12px 16px; margin-bottom:16px;">
            <div style="font-size:13px; font-weight:600; color:#b92b27; margin-bottom:6px;">Terjadi kesalahan:</div>
            <ul style="margin:0; padding-left:18px; font-size:13px; color:#b92b27;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="_edit_form" value="1">

            {{-- ROLE --}}
            <div class="form-group">
                <label>Role <span>*</span></label>
                <div class="role-picker">
                    <div class="role-option">
                        <input type="radio" name="role" value="admin" id="editRoleAdmin">
                        <label for="editRoleAdmin">
                            <div class="role-icon ri-admin">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                            </div>
                            Admin
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" name="role" value="hr" id="editRoleHR">
                        <label for="editRoleHR">
                            <div class="role-icon ri-hr">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            HR
                        </label>
                    </div>
                    <div class="role-option">
                        <input type="radio" name="role" value="kandidat" id="editRoleUser">
                        <label for="editRoleUser">
                            <div class="role-icon ri-user">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            Kandidat
                        </label>
                    </div>
                </div>
            </div>

            {{-- NAME --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Depan <span>*</span></label>
                    <input type="text" id="editFirstName" name="first_name" required>
                </div>
                <div class="form-group">
                    <label>Nama Belakang</label>
                    <input type="text" id="editLastName" name="last_name">
                </div>
            </div>

            {{-- EMAIL --}}
            <div class="form-group">
                <label>Email <span>*</span></label>
                <input type="email" id="editEmail" name="email" required>
            </div>

            {{-- STATUS --}}
            <div class="form-group full-width">
                <label>Status <span>*</span></label>
                <select name="status" id="editStatus">
                    <option value="active">Aktif</option>
                    <option value="nonactive">Nonaktif</option>
                </select>
                <small style="color: #64748b; font-size: 11px; margin-top: 4px; display: block;">
                    * Mengubah status ke <b>Aktif</b> akan otomatis memverifikasi email user.
                </small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                <button type="button" onclick="closeEditModal()" class="btn-cancel">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL: DELETE CONFIRMATION ================= --}}
<div id="modalDeleteUser" class="modal-overlay">
    <div class="modal-delete-box">
        <div class="modal-delete-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6" />
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                <path d="M10 11v6" />
                <path d="M14 11v6" />
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
            </svg>
        </div>
        <h4>Hapus User?</h4>
        <p>Apakah kamu yakin ingin menghapus <strong id="deleteUserName"></strong>? Tindakan ini tidak bisa dibatalkan.</p>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-delete-actions">
                <button type="submit" class="btn-danger">Ya, Hapus</button>
                <button type="button" onclick="closeDeleteModal()" class="btn-cancel">Batal</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ── CREATE MODAL ──
    function openCreateModal() {
        document.getElementById('modalCreateUser').classList.add('active');
    }

    function closeCreateModal() {
        document.getElementById('modalCreateUser').classList.remove('active');
    }

    // Client-side password validation for Create form
    document.getElementById('createForm').addEventListener('submit', function(e) {
        const pw = document.getElementById('createPassword').value;
        const pwc = document.getElementById('createPasswordConfirm').value;
        const errorEl = document.getElementById('createPasswordError');

        errorEl.style.display = 'none';

        if (pw.length < 8) {
            e.preventDefault();
            errorEl.innerText = 'Password minimal 8 karakter.';
            errorEl.style.display = 'block';
            return;
        }

        if (pw !== pwc) {
            e.preventDefault();
            errorEl.innerText = 'Konfirmasi password tidak sesuai.';
            errorEl.style.display = 'block';
            return;
        }
    });

    // Auto-reopen create modal if there are validation errors
    @if($errors->any() && old('_create_form'))
        openCreateModal();
    @endif

    // Auto-reopen edit modal if there are validation errors
    @if($errors->any() && old('_edit_form'))
        const modalEdit = document.getElementById('modalEditUser');
        modalEdit.classList.add('active');
        // We set the action back to the submitted URL
        document.getElementById('editForm').action = "{{ request()->url() }}";
    @endif

    // ── EDIT MODAL ──
    function openEditModal(id, firstName, lastName, email, role, status) {
        const modal = document.getElementById('modalEditUser');
        modal.classList.add('active');

        // Set form action
        document.getElementById('editForm').action = `/admin/users/${id}`;

        // Fill inputs
        document.getElementById('editFirstName').value = firstName;
        document.getElementById('editLastName').value = lastName;
        document.getElementById('editEmail').value = email;
        
        const statusEl = document.getElementById('editStatus');
        // Jika status saat ini pending, otomatis arahkan ke pilihan 'active' di modal
        if (status === 'pending') {
            statusEl.value = 'active';
        } else {
            statusEl.value = status;
        }

        // Set role radio
        document.querySelectorAll('#modalEditUser [name=role]').forEach(r => {
            r.checked = r.value === role;
        });
    }

    function closeEditModal() {
        document.getElementById('modalEditUser').classList.remove('active');
    }

    // ── DELETE MODAL ──
    function openDeleteModal(id, name) {
        document.getElementById('modalDeleteUser').classList.add('active');
        document.getElementById('deleteForm').action = `/admin/users/${id}`;
        document.getElementById('deleteUserName').innerText = name;
    }

    function closeDeleteModal() {
        document.getElementById('modalDeleteUser').classList.remove('active');
    }

    // ── Close modals on overlay click or Escape ──
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(m => {
                m.classList.remove('active');
            });
        }
    });
</script>
@endpush