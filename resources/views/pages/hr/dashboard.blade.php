@extends('layouts.hr_tailwind')

@section('title', 'Dashboard HR')

@section('content')

{{-- ===== GREETING ===== --}}
<div class="mb-8">
    <h1 class="font-h1 text-h1 text-primary">Manajemen Rekrutmen</h1>
    <p class="text-on-surface-variant font-body-lg mt-1">Kelola lowongan, pantau pelamar, dan update status kandidat dari satu tempat.</p>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    {{-- Card 1: Lowongan Aktif --}}
    <div class="bg-white p-6 rounded-xl border border-outline-variant hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-blue-50 rounded-lg">
                <span class="material-symbols-outlined text-[#002870]"
                      style="font-variation-settings:'FILL' 1;">work</span>
            </div>
            <span class="text-[10px] font-bold text-green-700 bg-green-50 px-2 py-1 rounded-lg">
                Aktif
            </span>
        </div>
        <p class="font-label-caps text-on-surface-variant uppercase mb-1">Lowongan Aktif</p>
        <h3 class="font-stat-number text-stat-number text-primary">{{ $totalActiveVacancies }}</h3>
    </div>

    {{-- Card 2: Total Pelamar --}}
    <div class="bg-white p-6 rounded-xl border border-outline-variant hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-yellow-50 rounded-lg">
                <span class="material-symbols-outlined text-[#f8b830]"
                      style="font-variation-settings:'FILL' 1;">group</span>
            </div>
            <span class="text-[10px] font-bold text-[#002870] bg-blue-50 px-2 py-1 rounded-lg">
                {{ $totalApplicantsToday }} Hari ini
            </span>
        </div>
        <p class="font-label-caps text-on-surface-variant uppercase mb-1">Total Pelamar</p>
        <h3 class="font-stat-number text-stat-number text-primary">{{ $totalApplicants }}</h3>
    </div>

    {{-- Card 3: Belum Diproses --}}
    <div class="bg-white p-6 rounded-xl border border-outline-variant hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-blue-50 rounded-lg">
                <span class="material-symbols-outlined text-[#002870]"
                      style="font-variation-settings:'FILL' 1;">pending_actions</span>
            </div>
            <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">
                Pending
            </span>
        </div>
        <p class="font-label-caps text-on-surface-variant uppercase mb-1">Belum Diproses</p>
        <h3 class="font-stat-number text-stat-number text-primary">{{ $statusCounts['pending'] ?? 0 }}</h3>
    </div>

    {{-- Card 4: Lolos Screening --}}
    <div class="bg-white p-6 rounded-xl border border-outline-variant hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-yellow-50 rounded-lg">
                <span class="material-symbols-outlined text-[#f8b830]"
                      style="font-variation-settings:'FILL' 1;">task_alt</span>
            </div>
            <span class="text-[10px] font-bold text-green-700 bg-green-50 px-2 py-1 rounded-lg">
                Lolos
            </span>
        </div>
        <p class="font-label-caps text-on-surface-variant uppercase mb-1">Lolos Screening</p>
        <h3 class="font-stat-number text-stat-number text-primary">{{ $statusCounts['lolos'] ?? 0 }}</h3>
    </div>

</div>

{{-- ===== MAIN BENTO GRID ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- LEFT: Lowongan Paling Diminati --}}
    <div class="lg:col-span-1 bg-white border border-outline-variant rounded-xl overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-h3 text-h3 text-primary">Lowongan Paling Diminati</h3>
            <a href="{{ route('hr.vacancies.index') }}"
               class="text-xs font-bold text-[#002870] hover:underline">
                Kelola
            </a>
        </div>

        <div class="flex-1 p-4 space-y-2">
            @forelse($topVacancies as $index => $vacancy)
                @php
                    $abbr = collect(explode(' ', $vacancy->title))
                        ->take(2)->map(fn($w) => strtoupper($w[0]))->join('');
                    $icons = ['code', 'palette', 'campaign', 'payments', 'engineering', 'analytics'];
                    $icon  = $icons[$index % count($icons)];
                @endphp
                <div class="p-4 rounded-lg border border-transparent hover:border-[#002870] hover:bg-blue-50/30 transition-all cursor-pointer group">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 bg-surface-container-low rounded-lg flex items-center justify-center font-bold text-[#002870] text-sm flex-shrink-0">
                            {{ $abbr }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-primary truncate group-hover:text-[#002870]">
                                {{ $vacancy->title }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $vacancy->type }} • {{ $vacancy->division }}
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-bold text-sm text-primary">{{ $vacancy->applications_count }}</p>
                            <p class="text-[10px] uppercase text-gray-400 font-bold">Pelamar</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <span class="material-symbols-outlined text-gray-300 mb-3" style="font-size:40px;">work_off</span>
                    <p class="text-sm text-gray-400">Belum ada data lowongan.</p>
                    <a href="{{ route('hr.vacancies.create') }}"
                       class="mt-3 text-xs font-bold text-[#002870] hover:underline">
                        + Buat Lowongan Baru
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- RIGHT: Kandidat Terbaru --}}
    <div class="lg:col-span-2 bg-white border border-outline-variant rounded-xl overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <h3 class="font-h3 text-h3 text-primary">Kandidat Terbaru</h3>
                <span class="bg-[#002870] text-white text-[10px] px-2 py-0.5 rounded-full font-bold tracking-wider">
                    LIVE
                </span>
            </div>
            <a href="{{ route('hr.applications.index') }}"
               class="text-xs font-bold text-[#002870] hover:underline">
                Lihat Semua
            </a>
        </div>

        <div class="flex-1 overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-low">
                    <tr>
                        <th class="px-6 py-3 font-label-caps text-on-surface-variant text-xs">Kandidat</th>
                        <th class="px-6 py-3 font-label-caps text-on-surface-variant text-xs">Posisi Lamaran</th>
                        <th class="px-6 py-3 font-label-caps text-on-surface-variant text-xs">Tanggal</th>
                        <th class="px-6 py-3 font-label-caps text-on-surface-variant text-xs">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentApplications as $app)
                        @php
                            $statusMap = [
                                'pending'     => ['label' => 'PENDING',   'bg' => 'bg-gray-50',   'text' => 'text-gray-600',   'border' => 'border-gray-200',  'dot' => 'bg-gray-400'],
                                'review'      => ['label' => 'IN REVIEW', 'bg' => 'bg-blue-50',   'text' => 'text-[#002870]',  'border' => 'border-blue-100',  'dot' => 'bg-[#002870]'],
                                'interview'   => ['label' => 'INTERVIEW', 'bg' => 'bg-yellow-50', 'text' => 'text-[#7c5800]',  'border' => 'border-yellow-100','dot' => 'bg-[#f8b830]'],
                                'lolos'       => ['label' => 'SHORTLISTED','bg'=> 'bg-green-50',  'text' => 'text-green-700',  'border' => 'border-green-100', 'dot' => 'bg-green-500'],
                                'tidak_lolos' => ['label' => 'DITOLAK',   'bg' => 'bg-red-50',    'text' => 'text-red-700',    'border' => 'border-red-100',   'dot' => 'bg-red-500'],
                            ];
                            $s = $statusMap[$app->status] ?? $statusMap['pending'];
                            $initial = strtoupper(substr($app->user->first_name ?? 'U', 0, 1));
                            $fullName = ($app->user->first_name ?? '') . ' ' . ($app->user->last_name ?? '');
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center font-bold text-[#002870] text-sm flex-shrink-0">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm text-primary">{{ trim($fullName) }}</p>
                                        <p class="text-[10px] text-gray-400">ID</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700">{{ $app->jobVacancy->title ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">
                                    {{ $app->applied_at ? $app->applied_at->diffForHumans() : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold border
                                    {{ $s['bg'] }} {{ $s['text'] }} {{ $s['border'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }}"></span>
                                    {{ $s['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('hr.applications.show', $app->id) }}"
                                   class="text-gray-400 hover:text-[#002870] transition-colors">
                                    <span class="material-symbols-outlined" style="font-size:20px;">arrow_forward</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <span class="material-symbols-outlined text-gray-300 block mb-2" style="font-size:36px;">inbox</span>
                                <p class="text-sm text-gray-400">Belum ada lamaran masuk.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-3 border-t border-gray-100 text-center">
            <a href="{{ route('hr.applications.index') }}"
               class="text-sm font-bold text-primary hover:text-[#002870] transition-colors">
                Lihat Semua Kandidat →
            </a>
        </div>
    </div>

</div>

{{-- ===== BOTTOM ROW ===== --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- CTA Banner --}}
    <div class="bg-[#002870] rounded-xl p-8 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h4 class="font-h2 text-h2 mb-2">Kelola Lowongan Baru</h4>
            <p class="text-blue-200 font-body-md mb-6 max-w-sm">
                Buat dan publikasikan lowongan kerja baru untuk menemukan talenta terbaik.
            </p>
            <button onclick="openVacancyModal()"
                    class="inline-flex items-center gap-2 font-bold py-3 px-8 rounded-lg transition-all active:scale-95"
                    style="background:#f8b830; color:#002870;">
                <span class="material-symbols-outlined" style="font-size:18px;">add</span>
                Buat Lowongan
            </button>
        </div>
        <span class="material-symbols-outlined absolute -right-6 -bottom-6 text-white/5"
              style="font-size:200px; font-variation-settings:'FILL' 1;">work</span>
    </div>

    {{-- Quick Stats --}}
    <div class="bg-white border border-outline-variant rounded-xl p-8">
        <h4 class="font-h3 text-h3 text-primary mb-5">Ringkasan Status</h4>
        <div class="space-y-3">
            @php
                $statItems = [
                    ['label' => 'Pending Review',   'count' => $statusCounts['pending'] ?? 0,     'color' => 'bg-gray-400'],
                    ['label' => 'Sedang Diproses',  'count' => $statusCounts['review'] ?? 0,      'color' => 'bg-[#002870]'],
                    ['label' => 'Lolos Screening',  'count' => $statusCounts['lolos'] ?? 0,       'color' => 'bg-green-500'],
                    ['label' => 'Tidak Lolos',      'count' => $statusCounts['tidak_lolos'] ?? 0, 'color' => 'bg-red-400'],
                ];
                $total = max(array_sum($statusCounts), 1);
            @endphp
            @foreach($statItems as $item)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-on-surface-variant font-medium">{{ $item['label'] }}</span>
                        <span class="font-bold text-primary">{{ $item['count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="{{ $item['color'] }} h-1.5 rounded-full transition-all duration-500"
                             style="width: {{ $total > 0 ? round($item['count']/$total*100) : 0 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

@endsection
