@extends('layouts.hr_tailwind')

@section('title', 'Kelola Lowongan')

@section('content')
<!-- Header -->
<header class="mb-8">
    <h1 class="font-h1 text-h1 text-primary-container">Lowongan Kerja</h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant mt-2">Kelola semua lowongan yang Anda buat</p>
</header>

<!-- Toolbar -->
<div class="bg-white border border-outline-variant p-4 rounded-xl shadow-sm mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
    <form method="GET" action="{{ route('hr.vacancies.index') }}" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <div class="relative w-full sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
            <input type="text" name="search" class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" placeholder="Cari lowongan..." value="{{ request('search') }}">
        </div>
        <select name="status" class="w-full sm:w-40 px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent bg-white" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>
    </form>
    <button onclick="openVacancyModal()"
            class="flex items-center gap-2 bg-[#002870] hover:bg-[#001544] text-white px-4 py-2
                   rounded-lg transition-colors font-bold text-sm w-full md:w-auto justify-center">
        <span class="material-symbols-outlined text-sm">add</span> Tambah Lowongan
    </button>
</div>

<!-- Table -->
<div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Lowongan</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Departemen</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Deadline</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelamar</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="py-3 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($vacancies as $vacancy)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6">
                            <strong class="text-gray-900 block">{{ $vacancy->title }}</strong>
                            <small class="text-gray-500">{{ $vacancy->division }}</small>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-700">{{ $vacancy->department }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg">{{ ucfirst($vacancy->type) }}</span>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-700">{{ $vacancy->deadline->format('d M Y') }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg">{{ $vacancy->applications_count }} pelamar</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($vacancy->status === 'open')
                                <span class="px-2 py-1 bg-green-50 text-green-700 text-[11px] uppercase font-bold rounded-lg inline-flex items-center gap-1">
                                    <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div> Open
                                </span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-500 text-[11px] uppercase font-bold rounded-lg inline-flex items-center gap-1">
                                    <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div> Closed
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-2">
                                <form method="POST" action="{{ route('hr.vacancies.toggle', $vacancy->id) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="p-1.5 rounded-md text-gray-500 hover:text-[#002870] hover:bg-blue-50 transition-colors focus:outline-none" title="{{ $vacancy->isOpen() ? 'Tutup' : 'Buka' }}">
                                        <span class="material-symbols-outlined text-lg">{{ $vacancy->isOpen() ? 'toggle_on' : 'toggle_off' }}</span>
                                    </button>
                                </form>
                                <a href="{{ route('hr.vacancies.edit', $vacancy->id) }}" class="p-1.5 rounded-md text-gray-500 hover:text-[#002870] hover:bg-blue-50 transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form method="POST" action="{{ route('hr.vacancies.destroy', $vacancy->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-md text-gray-500 hover:text-red-600 hover:bg-red-50 transition-colors focus:outline-none" title="Hapus">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center">
                            <span class="material-symbols-outlined text-gray-300 text-6xl">inbox</span>
                            <p class="text-gray-500 mt-2 font-medium">Belum ada lowongan. Mulai buat sekarang!</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($vacancies->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $vacancies->links() }}
    </div>
@endif

@endsection
