@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.manager')

@section('title', 'Pelamar Departemen ' . $department)

@section('content')
<!-- Header -->
<header class="mb-8">
    <h1 class="font-h1 text-h1 text-primary">Pelamar Departemen {{ $department }}</h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant mt-1">Data pelamar yang melamar ke lowongan di departemen Anda (read-only)</p>
</header>

<!-- Filter Bar -->
<div class="bg-white border border-outline-variant p-5 rounded-xl shadow-sm mb-6">
    <form method="GET" action="{{ route('manager.applications.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
        <!-- Search -->
        <div class="md:col-span-5">
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Cari Kandidat</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">search</span>
                <input type="text" name="search"
                       class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870]"
                       placeholder="Nama / email..." value="{{ request('search') }}">
            </div>
        </div>
        <!-- Status -->
        <div class="md:col-span-3">
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] bg-white">
                <option value="">Semua</option>
                <option value="pending"     {{ request('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                <option value="review"      {{ request('status') == 'review'      ? 'selected' : '' }}>Ditinjau</option>
                <option value="lolos"       {{ request('status') == 'lolos'       ? 'selected' : '' }}>Lolos</option>
                <option value="tidak_lolos" {{ request('status') == 'tidak_lolos' ? 'selected' : '' }}>Tidak Lolos</option>
            </select>
        </div>
        <!-- Buttons -->
        <div class="md:col-span-4 flex gap-2">
            <button type="submit"
                    class="flex-1 flex items-center justify-center gap-1 bg-[#f8b830] hover:bg-[#eab308] text-[#002870] px-3 py-2 rounded-lg transition-colors font-bold text-sm">
                <span class="material-symbols-outlined text-sm">filter_alt</span> Filter
            </button>
            <a href="{{ route('manager.applications.index') }}"
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
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kandidat</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Posisi</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pendidikan</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Melamar</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($applications as $app)
                    @php
                        $statusMap = [
                            'pending'     => ['label' => 'Pending',      'cls' => 'bg-gray-100 text-gray-600',   'dot' => 'bg-gray-400'],
                            'review'      => ['label' => 'Ditinjau',     'cls' => 'bg-blue-50 text-[#002870]',   'dot' => 'bg-[#002870]'],
                            'lolos'       => ['label' => 'Lolos',        'cls' => 'bg-green-50 text-green-700',  'dot' => 'bg-green-500'],
                            'tidak_lolos' => ['label' => 'Tidak Lolos',  'cls' => 'bg-red-50 text-red-700',     'dot' => 'bg-red-400'],
                        ];
                        $s = $statusMap[$app->status] ?? $statusMap['pending'];
                    @endphp
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <!-- Kandidat -->
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($app->user->avatar)
                                        <img src="{{ Storage::url($app->user->avatar) }}" alt="{{ $app->user->full_name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-blue-50 flex items-center justify-center font-bold text-[#002870] text-sm">
                                            {{ strtoupper(substr($app->user->first_name, 0, 1)) }}
                                        </div>
                                    @endif
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

                        <!-- Status -->
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-bold {{ $s['cls'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }} flex-shrink-0"></span>
                                {{ $s['label'] }}
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-4 text-center">
                            <a href="{{ route('manager.applications.show', $app->id) }}"
                               class="inline-flex items-center gap-1 text-[#002870] hover:text-[#001544]
                                      font-bold text-sm bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <span class="material-symbols-outlined text-gray-300 block mb-2" style="font-size:48px;">inbox</span>
                            <p class="text-gray-400 font-medium">Belum ada pelamar di departemen {{ $department }}.</p>
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

@endsection
