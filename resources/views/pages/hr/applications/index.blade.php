@extends('layouts.hr_tailwind')

@section('title', 'Daftar Kandidat')

@section('content')
<!-- Header -->
<header class="mb-lg flex justify-between items-end">
    <div>
        <h1 class="font-h1 text-h1 text-primary">Kandidat & Lamaran</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mt-1">Kelola semua lamaran yang masuk</p>
    </div>
    <div id="bulkBar" class="hidden items-center gap-3">
        <span id="bulkCount" class="text-sm font-semibold text-gray-600">0 dipilih</span>
        <div class="relative">
            <select id="bulkStatusSelect"
                    class="h-9 pl-3 pr-8 text-sm font-semibold border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] bg-white appearance-none">
                <option value="">Ubah Status...</option>
                <option value="pending">Pending</option>
                <option value="review">In Review</option>
                <option value="lolos">Lolos</option>
                <option value="tidak_lolos">Tidak Lolos</option>
            </select>
            <span class="material-symbols-outlined absolute right-2 top-1.5 text-gray-400 pointer-events-none" style="font-size:16px;">expand_more</span>
        </div>
        <button onclick="applyBulkStatus()"
                class="h-9 px-4 bg-[#002870] hover:bg-[#001544] text-white text-sm font-bold rounded-lg transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined" style="font-size:16px;">check_circle</span>
            Terapkan
        </button>
        <button onclick="clearSelection()"
                class="h-9 px-3 text-gray-500 hover:bg-gray-100 text-sm rounded-lg transition-colors">
            Batal
        </button>
    </div>
</header>

<!-- Filter Bar -->
<div class="bg-white border border-outline-variant p-sm rounded-xl shadow-sm mb-md">
    <form method="GET" action="{{ route('hr.applications.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
        <!-- Search -->
        <div class="md:col-span-3">
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Cari Kandidat</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">search</span>
                <input type="text" name="search"
                       class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870]"
                       placeholder="Nama / email..." value="{{ request('search') }}">
            </div>
        </div>
        <!-- Status -->
        <div class="md:col-span-2">
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] bg-white">
                <option value="">Semua</option>
                <option value="pending"     {{ request('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                <option value="review"      {{ request('status') == 'review'      ? 'selected' : '' }}>In Review</option>
                <option value="lolos"       {{ request('status') == 'lolos'       ? 'selected' : '' }}>Lolos</option>
                <option value="tidak_lolos" {{ request('status') == 'tidak_lolos' ? 'selected' : '' }}>Tidak Lolos</option>
            </select>
        </div>
        <!-- Department -->
        <div class="md:col-span-2">
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Departemen</label>
            <select name="department" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] bg-white">
                <option value="">Semua</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                @endforeach
            </select>
        </div>
        <!-- Education -->
        <div class="md:col-span-2">
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Pendidikan</label>
            <select name="education" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] bg-white">
                <option value="">Semua</option>
                @foreach(['SMA','D3','S1','S2','S3'] as $edu)
                    <option value="{{ $edu }}" {{ request('education') == $edu ? 'selected' : '' }}>{{ $edu }}</option>
                @endforeach
            </select>
        </div>
        <!-- Buttons -->
        <div class="md:col-span-3 flex gap-2">
            <button type="submit"
                    class="flex-1 flex items-center justify-center gap-1 bg-[#002870] hover:bg-[#001544] text-white px-3 py-2 rounded-lg transition-colors font-bold text-sm">
                <span class="material-symbols-outlined text-sm">filter_alt</span> Filter
            </button>
            <a href="{{ route('hr.applications.index') }}"
               class="flex-1 flex items-center justify-center gap-1 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-3 py-2 rounded-lg transition-colors font-bold text-sm">
                <span class="material-symbols-outlined text-sm">close</span> Reset
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <!-- Checkbox all -->
                    <th class="py-3 pl-5 pr-2 w-10">
                        <input type="checkbox" id="checkAll" onclick="toggleAll(this)"
                               class="w-4 h-4 rounded border-gray-300 text-[#002870] focus:ring-[#002870] cursor-pointer accent-[#002870]">
                    </th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kandidat</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Posisi</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pendidikan</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Melamar</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="candidateTable">
                @forelse($applications as $app)
                    @php
                        $statusMap = [
                            'pending'     => ['label' => 'Pending',      'cls' => 'bg-gray-100 text-gray-600',   'dot' => 'bg-gray-400',   'ring' => 'ring-gray-300'],
                            'review'      => ['label' => 'In Review',    'cls' => 'bg-blue-50 text-[#002870]',   'dot' => 'bg-[#002870]', 'ring' => 'ring-blue-200'],
                            'lolos'       => ['label' => 'Lolos',        'cls' => 'bg-green-50 text-green-700',  'dot' => 'bg-green-500',  'ring' => 'ring-green-200'],
                            'tidak_lolos' => ['label' => 'Tidak Lolos',  'cls' => 'bg-red-50 text-red-700',     'dot' => 'bg-red-400',    'ring' => 'ring-red-200'],
                        ];
                        $s = $statusMap[$app->status] ?? $statusMap['pending'];
                    @endphp
                    <tr class="hover:bg-gray-50/70 transition-colors candidate-row" data-id="{{ $app->id }}">

                        <!-- Checkbox -->
                        <td class="py-4 pl-5 pr-2">
                            <input type="checkbox" value="{{ $app->id }}"
                                   class="row-check w-4 h-4 rounded border-gray-300 cursor-pointer accent-[#002870]"
                                   onchange="onRowCheck()">
                        </td>

                        <!-- Kandidat -->
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center font-bold text-[#002870] text-sm flex-shrink-0">
                                    {{ strtoupper(substr($app->user->first_name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong class="text-gray-900 block text-sm">{{ $app->user->full_name }}</strong>
                                    <small class="text-gray-400">{{ $app->user->email }}</small>
                                </div>
                            </div>
                        </td>

                        <!-- Posisi -->
                        <td class="py-4 px-4">
                            <strong class="text-gray-800 block text-sm">{{ $app->jobVacancy->title }}</strong>
                            <small class="text-gray-400">{{ $app->jobVacancy->department }}</small>
                        </td>

                        <!-- Pendidikan -->
                        <td class="py-4 px-4">
                            @if($app->user->profile && $app->user->profile->last_education)
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg">
                                    {{ $app->user->profile->last_education }}
                                </span>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>

                        <!-- Tanggal -->
                        <td class="py-4 px-4 text-sm text-gray-500">
                            {{ $app->applied_at->format('d M Y') }}
                        </td>

                        <!-- Status — clickable badge dengan dropdown -->
                        <td class="py-4 px-4">
                            <div class="relative inline-block status-dropdown-wrap">
                                <button type="button"
                                        onclick="toggleStatusDropdown({{ $app->id }}, this)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-bold border
                                               cursor-pointer select-none ring-0 hover:ring-2 transition-all
                                               {{ $s['cls'] }} {{ $s['ring'] }}"
                                        title="Klik untuk ubah status">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }} flex-shrink-0"></span>
                                    <span class="status-label">{{ $s['label'] }}</span>
                                    <span class="material-symbols-outlined" style="font-size:14px;">expand_more</span>
                                </button>

                                <!-- Status dropdown -->
                                <div id="statusDrop-{{ $app->id }}"
                                     class="hidden absolute left-0 top-full mt-1 z-50 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden"
                                     style="min-width:160px;">
                                    @foreach([
                                        'pending'     => ['Pending',     'text-gray-600',   'bg-gray-400'],
                                        'review'      => ['In Review',   'text-[#002870]',  'bg-[#002870]'],
                                        'lolos'       => ['Lolos',       'text-green-700',  'bg-green-500'],
                                        'tidak_lolos' => ['Tidak Lolos', 'text-red-600',    'bg-red-400'],
                                    ] as $val => [$lbl, $txt, $dot])
                                        <form method="POST" action="{{ route('hr.applications.updateStatus', $app->id) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $val }}">
                                            <button type="submit"
                                                    class="flex items-center gap-2 w-full px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors
                                                           {{ $app->status === $val ? 'font-bold bg-gray-50' : '' }} {{ $txt }}">
                                                <span class="w-2 h-2 rounded-full {{ $dot }} flex-shrink-0"></span>
                                                {{ $lbl }}
                                                @if($app->status === $val)
                                                    <span class="material-symbols-outlined ml-auto" style="font-size:14px;">check</span>
                                                @endif
                                            </button>
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-4 text-center">
                            <a href="{{ route('hr.applications.show', $app->id) }}"
                               class="inline-flex items-center gap-1 text-[#002870] hover:text-[#001544]
                                      font-bold text-sm bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <span class="material-symbols-outlined text-gray-300 block mb-2" style="font-size:48px;">inbox</span>
                            <p class="text-gray-400 font-medium">Belum ada lamaran yang masuk.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($applications->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $applications->links() }}
    </div>
@endif

<!-- Hidden bulk-update form -->
<form id="bulkForm" method="POST" action="{{ route('hr.applications.bulkStatus') }}" class="hidden">
    @csrf @method('PATCH')
    <input type="hidden" name="status" id="bulkStatusInput">
    <div id="bulkIdsContainer"></div>
</form>

@endsection

@push('scripts')
<script>
/* ── Status dropdown ── */
function toggleStatusDropdown(id, btn) {
    // Close all other dropdowns
    document.querySelectorAll('[id^="statusDrop-"]').forEach(d => {
        if (d.id !== 'statusDrop-' + id) d.classList.add('hidden');
    });
    document.getElementById('statusDrop-' + id).classList.toggle('hidden');
    // Prevent event from bubbling to the close-all listener
    event.stopPropagation();
}

// Close dropdowns when clicking outside
document.addEventListener('click', () => {
    document.querySelectorAll('[id^="statusDrop-"]').forEach(d => d.classList.add('hidden'));
});

/* ── Checkbox logic ── */
function toggleAll(master) {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = master.checked);
    onRowCheck();
}

function onRowCheck() {
    const checked = document.querySelectorAll('.row-check:checked');
    const total   = document.querySelectorAll('.row-check');
    const bar     = document.getElementById('bulkBar');
    const count   = document.getElementById('bulkCount');
    const master  = document.getElementById('checkAll');

    if (checked.length > 0) {
        bar.classList.remove('hidden');
        bar.classList.add('flex');
        count.textContent = checked.length + ' dipilih';
    } else {
        bar.classList.add('hidden');
        bar.classList.remove('flex');
    }
    // Indeterminate state for master checkbox
    master.indeterminate = (checked.length > 0 && checked.length < total.length);
    master.checked = (checked.length === total.length);
}

function clearSelection() {
    document.querySelectorAll('.row-check, #checkAll').forEach(cb => {
        cb.checked = false;
        cb.indeterminate = false;
    });
    onRowCheck();
}

function applyBulkStatus() {
    const status = document.getElementById('bulkStatusSelect').value;
    if (!status) { alert('Pilih status terlebih dahulu.'); return; }

    const ids = Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);
    if (ids.length === 0) { alert('Pilih setidaknya satu kandidat.'); return; }

    const labels = { pending:'Pending', review:'In Review', lolos:'Lolos', tidak_lolos:'Tidak Lolos' };
    if (!confirm(`Ubah status ${ids.length} kandidat menjadi "${labels[status]}"?`)) return;

    document.getElementById('bulkStatusInput').value = status;
    const container = document.getElementById('bulkIdsContainer');
    container.innerHTML = ids.map(id => `<input type="hidden" name="ids[]" value="${id}">`).join('');
    document.getElementById('bulkForm').submit();
}
</script>
@endpush
