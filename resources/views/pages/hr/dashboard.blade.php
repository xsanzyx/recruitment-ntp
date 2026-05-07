@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.hr_tailwind')

@section('title', 'Dashboard HR')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-[28px] font-extrabold text-[#001544] tracking-tight leading-tight">Recruitment Dashboard</h1>
        <p class="text-gray-500 text-[15px] mt-1">Manage aerospace engineering talent and active job openings.</p>
    </div>
    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-[#001544] shadow-sm">
        <span class="material-symbols-outlined" style="font-size:18px;">calendar_today</span>
        {{ now()->translatedFormat('F d, Y') }}
    </div>
</div>

{{-- ===== 4 STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    {{-- Card 1: Lowongan Aktif --}}
    <div class="bg-white p-5 rounded-xl border border-gray-100 hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Lowongan Aktif</p>
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#002870]" style="font-size:22px; font-variation-settings:'FILL' 1;">work</span>
            </div>
        </div>
        <h3 class="text-[32px] font-extrabold text-[#001544] leading-none mb-2">{{ $totalActiveVacancies }}</h3>
        <div class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-green-500" style="font-size:16px;">trending_up</span>
            <span class="text-[12px] text-gray-400 font-medium">Stable current flow</span>
        </div>
    </div>

    {{-- Card 2: Total Pelamar --}}
    <div class="bg-white p-5 rounded-xl border border-gray-100 hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Total Pelamar</p>
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-red-500" style="font-size:22px; font-variation-settings:'FILL' 1;">group</span>
            </div>
        </div>
        <h3 class="text-[32px] font-extrabold text-[#001544] leading-none mb-2">{{ $totalApplicants }}</h3>
        <div class="flex items-center gap-1.5">
            <span class="text-[12px] text-gray-400 font-medium">— Monthly intake</span>
        </div>
    </div>

    {{-- Card 3: Belum Diproses --}}
    <div class="bg-white p-5 rounded-xl border border-gray-100 hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Belum Diproses</p>
            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-orange-500" style="font-size:22px; font-variation-settings:'FILL' 1;">pending_actions</span>
            </div>
        </div>
        <h3 class="text-[32px] font-extrabold text-[#001544] leading-none mb-2">{{ $statusCounts['pending'] ?? 0 }}</h3>
        <div class="flex items-center gap-1.5">
            @if(($statusCounts['pending'] ?? 0) == 0)
                <span class="material-symbols-outlined text-green-500" style="font-size:16px;">check_circle</span>
                <span class="text-[12px] text-gray-400 font-medium">All clear</span>
            @else
                <span class="material-symbols-outlined text-orange-500" style="font-size:16px;">schedule</span>
                <span class="text-[12px] text-gray-400 font-medium">Needs attention</span>
            @endif
        </div>
    </div>

    {{-- Card 4: Lolos Screening --}}
    <div class="bg-white p-5 rounded-xl border border-gray-100 hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Lolos Screening</p>
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-green-600" style="font-size:22px; font-variation-settings:'FILL' 1;">task_alt</span>
            </div>
        </div>
        <h3 class="text-[32px] font-extrabold text-[#001544] leading-none mb-2">{{ $statusCounts['lolos'] ?? 0 }}</h3>
        <div class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-green-500" style="font-size:16px;">verified</span>
            <span class="text-[12px] text-gray-400 font-medium">Ready for interview</span>
        </div>
    </div>

</div>

{{-- ===== MAIN 2-COLUMN GRID ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- LEFT: Lowongan Paling Diminati --}}
    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-[16px] font-bold text-[#001544]">Lowongan Paling Diminati</h3>
            <a href="{{ route('hr.vacancies.index') }}"
               class="text-[12px] font-bold text-[#002870] hover:underline uppercase tracking-wider">
                Lihat Semua
            </a>
        </div>

        <div class="flex-1 p-4 space-y-1">
            @forelse($topVacancies as $index => $vacancy)
                @php
                    $iconColors = [
                        ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'terminal'],
                        ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'icon' => 'palette'],
                        ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'campaign'],
                        ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'engineering'],
                    ];
                    $ic = $iconColors[$index % count($iconColors)];
                @endphp
                <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 transition-all cursor-pointer group">
                    <div class="w-11 h-11 rounded-xl {{ $ic['bg'] }} flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined {{ $ic['text'] }}" style="font-size:22px; font-variation-settings:'FILL' 1;">{{ $ic['icon'] }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-sm text-[#001544] truncate group-hover:text-[#002870]">
                            {{ $vacancy->title }}
                        </p>
                        <p class="text-[12px] text-gray-400 mt-0.5">
                            {{ $vacancy->department }}
                        </p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-[13px] font-extrabold text-[#001544]">
                            {{ str_pad($vacancy->applications_count, 2, '0', STR_PAD_LEFT) }}
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Applicants</span>
                        </p>
                        <p class="text-[10px] text-gray-300 mt-0.5">Updated {{ $vacancy->updated_at->diffForHumans(null, true) }} ago</p>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <span class="material-symbols-outlined text-gray-300 mb-3" style="font-size:40px;">work_off</span>
                    <p class="text-sm text-gray-400">Belum ada data lowongan.</p>
                    <button onclick="openVacancyModal()"
                       class="mt-3 text-xs font-bold text-[#002870] hover:underline">
                        + Buat Lowongan Baru
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    {{-- RIGHT: Kandidat Terbaru --}}
    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-[16px] font-bold text-[#001544]">Kandidat Terbaru</h3>
            <a href="{{ route('hr.applications.index') }}"
               class="text-[12px] font-bold text-[#002870] hover:underline uppercase tracking-wider">
                Lihat Semua
            </a>
        </div>

        <div class="flex-1">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-6 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Candidate Name</th>
                        <th class="px-4 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Applied For</th>
                        <th class="px-4 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Applied</th>
                        <th class="px-4 py-3 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentApplications as $app)
                        @php
                            $statusMap = [
                                'pending'     => ['label' => 'PENDING',     'bg' => 'bg-gray-100',  'text' => 'text-gray-600'],
                                'review'      => ['label' => 'IN REVIEW',   'bg' => 'bg-blue-50',   'text' => 'text-[#002870]'],
                                'lolos'       => ['label' => 'SHORTLISTED', 'bg' => 'bg-green-50',  'text' => 'text-green-700'],
                                'tidak_lolos' => ['label' => 'REJECTED',    'bg' => 'bg-red-50',    'text' => 'text-red-600'],
                            ];
                            $s = $statusMap[$app->status] ?? $statusMap['pending'];
                            $initial = strtoupper(substr($app->user->first_name ?? 'U', 0, 1)) . strtoupper(substr($app->user->last_name ?? '', 0, 1));
                            $fullName = trim(($app->user->first_name ?? '') . ' ' . ($app->user->last_name ?? ''));
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($app->user->avatar)
                                        <img src="{{ Storage::url($app->user->avatar) }}" alt="{{ $fullName }}"
                                             class="w-9 h-9 rounded-full object-cover flex-shrink-0 border border-gray-200">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-[#001544] flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">
                                            {{ $initial }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-sm text-[#001544]">{{ $fullName }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-600">{{ $app->jobVacancy->title ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-400">
                                    {{ $app->applied_at ? $app->applied_at->diffForHumans(null, true) . ' ago' : '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold tracking-wider
                                    {{ $s['bg'] }} {{ $s['text'] }}">
                                    {{ $s['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <span class="material-symbols-outlined text-gray-300 block mb-2" style="font-size:36px;">inbox</span>
                                <p class="text-sm text-gray-400">No other recent candidates</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ===== CTA BANNER ===== --}}
<div class="bg-[#001544] rounded-2xl p-8 md:p-10 relative overflow-hidden">
    {{-- Decorative gradient accent --}}
    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#f8b830] via-[#f59e0b] to-[#f8b830]"></div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative z-10">
        <div class="max-w-lg">
            <h4 class="text-[22px] font-extrabold text-white mb-2">Kelola Lowongan Baru</h4>
            <p class="text-blue-200/80 text-[14px] leading-relaxed">
                Streamline your aerospace recruitment process. Create precision-targeted job openings
                for specialized engineering roles within our institutional framework.
            </p>
        </div>
        <button onclick="openVacancyModal()"
                class="inline-flex items-center gap-2 font-extrabold py-3.5 px-8 rounded-xl transition-all active:scale-95 hover:brightness-110 shadow-lg flex-shrink-0"
                style="background:#f8b830; color:#001544;">
            <span class="material-symbols-outlined" style="font-size:20px;">add_circle</span>
            Buat Lowongan
        </button>
    </div>

    {{-- Background decorative icon --}}
    <span class="material-symbols-outlined absolute -right-8 -bottom-8 text-white/[0.03]"
          style="font-size:220px; font-variation-settings:'FILL' 1;">work</span>
</div>

@endsection
