@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.hr_tailwind')

@section('title', 'Detail Kandidat — ' . $application->user->full_name)

@section('content')

{{-- ═══════════════ HEADER ═══════════════ --}}
<header class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#002870] tracking-tight">Detail Kandidat</h1>
        <p class="text-gray-500 text-sm mt-1">Informasi lengkap pelamar untuk posisi <strong class="text-gray-700">{{ $application->jobVacancy->title }}</strong></p>
    </div>
    <a href="{{ route('hr.applications.index') }}"
       class="flex items-center gap-1.5 px-4 py-2 text-[#002870] font-semibold text-sm border border-[#002870]/20 rounded-lg hover:bg-[#002870]/5 transition-all">
        <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span> Kembali
    </a>
</header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

    {{-- ═══════════════ LEFT COLUMN ═══════════════ --}}
    <div class="lg:col-span-2 space-y-8">

        {{-- ── Profile Card ── --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                {{-- Top: Avatar + Name + Badge --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 mb-8">
                    <div class="flex items-center gap-5">
                        @if($application->user->avatar)
                            <img src="{{ Storage::url($application->user->avatar) }}" alt="{{ $application->user->full_name }}"
                                 class="w-16 h-16 rounded-2xl object-cover shadow-md shadow-blue-900/20 shrink-0 border border-gray-200">
                        @else
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center bg-gradient-to-br from-[#002870] to-[#0048c7] text-white text-xl font-bold shadow-md shadow-blue-900/20 shrink-0">
                                {{ strtoupper(substr($application->user->first_name, 0, 1)) }}{{ strtoupper(substr($application->user->last_name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 leading-tight">{{ $application->user->full_name }}</h2>
                            <span class="text-gray-400 text-sm mt-0.5 block">{{ $application->user->email }}</span>
                        </div>
                    </div>
                    <div>
                        @php
                            $badgeStyles = match($application->status_badge) {
                                'warning' => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-100',
                                'info'    => 'bg-sky-50 text-sky-700 border-sky-200 ring-sky-100',
                                'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-100',
                                'danger'  => 'bg-rose-50 text-rose-700 border-rose-200 ring-rose-100',
                                default   => 'bg-gray-50 text-gray-600 border-gray-200 ring-gray-100',
                            };
                        @endphp
                        <span class="px-3.5 py-1.5 {{ $badgeStyles }} border ring-2 text-xs font-bold uppercase rounded-full tracking-wide">{{ $application->status_label }}</span>
                    </div>
                </div>

                {{-- Job Info Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="flex items-center gap-3.5 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#002870] flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined" style="font-size:20px;">work</span>
                        </div>
                        <div class="min-w-0">
                            <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Posisi</small>
                            <strong class="text-sm text-gray-800 block truncate">{{ $application->jobVacancy->title }}</strong>
                        </div>
                    </div>
                    <div class="flex items-center gap-3.5 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#002870] flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined" style="font-size:20px;">domain</span>
                        </div>
                        <div class="min-w-0">
                            <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Departemen</small>
                            <strong class="text-sm text-gray-800 block truncate">{{ $application->jobVacancy->department }}</strong>
                        </div>
                    </div>
                    <div class="flex items-center gap-3.5 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#002870] flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined" style="font-size:20px;">calendar_month</span>
                        </div>
                        <div class="min-w-0">
                            <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal Melamar</small>
                            <strong class="text-sm text-gray-800 block">{{ $application->applied_at->format('d M Y, H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Informasi Pribadi ── --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 sm:px-8 py-5 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[#002870]" style="font-size:18px;">person</span>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Informasi Pribadi</h3>
            </div>
            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                    {{-- No. Telepon --}}
                    <div class="space-y-1">
                        <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">No. Telepon</small>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-400" style="font-size:16px;">call</span>
                            <strong class="text-sm text-gray-800">{{ $application->phone ?? '—' }}</strong>
                        </div>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="space-y-1">
                        <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jenis Kelamin</small>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-400" style="font-size:16px;">wc</span>
                            <strong class="text-sm text-gray-800">{{ $application->gender ?? '—' }}</strong>
                        </div>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="space-y-1">
                        <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tanggal Lahir</small>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-400" style="font-size:16px;">cake</span>
                            <strong class="text-sm text-gray-800">{{ $application->birthdate ? $application->birthdate->format('d M Y') : '—' }}</strong>
                        </div>
                    </div>

                    {{-- Pendidikan --}}
                    <div class="space-y-1">
                        <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pendidikan Terakhir</small>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-400" style="font-size:16px;">school</span>
                            @php
                                $educationStr = '—';
                                if ($application->education && is_array($application->education)) {
                                    $validEds = array_filter($application->education, function($ed) {
                                        return !empty($ed['level']) || !empty($ed['institution']);
                                    });
                                    if (count($validEds) > 0) {
                                        $lastEd = end($validEds);
                                        $parts = array_filter([
                                            $lastEd['level'] ?? null,
                                            $lastEd['major'] ?? null,
                                        ]);
                                        $institution = $lastEd['institution'] ?? null;
                                        $educationStr = implode(' ', $parts);
                                        if ($institution) $educationStr .= ' — ' . $institution;
                                    }
                                }
                            @endphp
                            <strong class="text-sm text-gray-800">{{ $educationStr ?: '—' }}</strong>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="sm:col-span-2 space-y-1">
                        <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Alamat</small>
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-gray-400 mt-0.5" style="font-size:16px;">location_on</span>
                            <strong class="text-sm text-gray-800">{{ $application->address ?? '—' }}</strong>
                        </div>
                    </div>

                    {{-- Ringkasan --}}
                    @if($application->summary)
                    <div class="sm:col-span-2 space-y-1.5">
                        <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Ringkasan Profil</small>
                        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line bg-slate-50 rounded-xl p-4 border border-slate-100">{{ $application->summary }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Riwayat Pendidikan (Detail) ── --}}
        @if($application->education && is_array($application->education))
            @php $validEducation = array_filter($application->education, fn($e) => !empty($e['level']) || !empty($e['institution'])); @endphp
            @if(count($validEducation) > 0)
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#002870]" style="font-size:18px;">school</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base">Riwayat Pendidikan</h3>
                </div>
                <div class="p-6 sm:p-8 space-y-4">
                    @foreach($validEducation as $edu)
                    <div class="flex gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#002870] flex items-center justify-center shrink-0 mt-0.5">
                            <span class="material-symbols-outlined" style="font-size:18px;">school</span>
                        </div>
                        <div class="space-y-0.5 min-w-0">
                            <strong class="text-sm text-gray-900 block">{{ $edu['level'] ?? '' }} {{ $edu['major'] ?? '' }}</strong>
                            <span class="text-xs text-gray-500 block">{{ $edu['institution'] ?? '—' }}</span>
                            <span class="text-xs text-gray-400 block">
                                {{ $edu['year_start'] ?? '' }}{{ !empty($edu['year_end']) ? ' — ' . $edu['year_end'] : '' }}
                                @if(!empty($edu['gpa']))
                                    &nbsp;·&nbsp;IPK {{ $edu['gpa'] }}
                                @endif
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif

        {{-- ── Pengalaman Kerja ── --}}
        @if($application->experience && is_array($application->experience))
            @php $validExp = array_filter($application->experience, fn($e) => !empty($e['position']) || !empty($e['company'])); @endphp
            @if(count($validExp) > 0)
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 sm:px-8 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[#002870]" style="font-size:18px;">business_center</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base">Pengalaman Kerja</h3>
                </div>
                <div class="p-6 sm:p-8 space-y-4">
                    @foreach($validExp as $exp)
                    <div class="flex gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 mt-0.5">
                            <span class="material-symbols-outlined" style="font-size:18px;">work_history</span>
                        </div>
                        <div class="space-y-0.5 min-w-0">
                            <strong class="text-sm text-gray-900 block">{{ $exp['position'] ?? '—' }}</strong>
                            <span class="text-xs text-gray-500 block">{{ $exp['company'] ?? '—' }}
                                @if(!empty($exp['current']) && $exp['current']) <span class="inline-block px-1.5 py-0.5 text-[10px] font-bold bg-green-100 text-green-700 rounded ml-1">Saat ini</span> @endif
                            </span>
                            <span class="text-xs text-gray-400 block">
                                {{ $exp['year_start'] ?? '' }}{{ !empty($exp['year_end']) ? ' — ' . $exp['year_end'] : ' — Sekarang' }}
                            </span>
                            @if(!empty($exp['description']))
                                <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">{{ $exp['description'] }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif

    </div>

    {{-- ═══════════════ RIGHT COLUMN (Sticky) ═══════════════ --}}
    <div class="space-y-6 lg:sticky lg:top-6 self-start">

        {{-- ── Card 1: Resume & Dokumen ── --}}
        @if($application->resume_path || !empty($application->documents))
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[#002870]" style="font-size:18px;">folder_open</span>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Resume & Dokumen</h3>
            </div>
            <div class="p-6 space-y-5">
                {{-- Resume --}}
                @if($application->resume_path)
                <div>
                    <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">CV / Resume Utama</small>
                    <a href="{{ route('hr.applications.download', [$application->id, 'resume']) }}"
                       class="w-full inline-flex items-center justify-center gap-3 px-5 py-3 bg-[#002870] text-white font-semibold text-sm rounded-xl hover:bg-[#001a4d] transition-all shadow-md shadow-blue-900/15 active:scale-[.97]">
                        <span class="material-symbols-outlined" style="font-size:18px;">download</span>
                        Download Resume
                    </a>
                </div>
                @endif

                {{-- Extra Documents --}}
                @if(!empty($application->documents))
                <div>
                    <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Dokumen Pendukung</small>
                    <div class="space-y-2">
                        @foreach($application->documents as $index => $doc)
                        <a href="{{ route('hr.applications.download', [$application->id, 'document', $index]) }}"
                           class="flex items-center gap-3 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 hover:border-slate-300 transition-all group">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-[#002870] flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined" style="font-size:16px;">description</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-sm font-semibold text-gray-700 block truncate">{{ $doc['name'] }}</span>
                                <span class="text-[10px] text-gray-400 uppercase tracking-wider">Klik untuk download</span>
                            </div>
                            <span class="material-symbols-outlined text-gray-300 group-hover:text-[#002870] transition-colors" style="font-size:18px;">download</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- ── Card 2: Update Status ── --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[#002870]" style="font-size:18px;">published_with_changes</span>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Update Status</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('hr.applications.updateStatus', $application->id) }}">
                    @csrf @method('PATCH')

                    <div class="mb-5">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Status Baru</label>
                        <div class="relative">
                            <select name="status"
                                    class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('status') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none appearance-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="review" {{ $application->status == 'review' ? 'selected' : '' }}>🔍 Sedang Direview</option>
                                <option value="lolos" {{ $application->status == 'lolos' ? 'selected' : '' }}>✅ Lolos</option>
                                <option value="tidak_lolos" {{ $application->status == 'tidak_lolos' ? 'selected' : '' }}>❌ Tidak Lolos</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-400 pointer-events-none" style="font-size:18px;">expand_more</span>
                        </div>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Catatan Review</label>
                        <textarea name="review_notes" rows="3"
                                  class="w-full px-4 py-3 bg-slate-50 border border-gray-200 rounded-xl text-sm outline-none resize-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all"
                                  placeholder="Tambahkan catatan...">{{ old('review_notes', $application->review_notes) }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 h-11 bg-[#002870] text-white font-bold text-sm rounded-xl hover:bg-[#001a4d] transition-all shadow-md shadow-blue-900/15 active:scale-[.97]">
                        <span class="material-symbols-outlined" style="font-size:16px;">check_circle</span> Simpan Status
                    </button>
                </form>
            </div>
        </div>

        {{-- ── Card 3: Info Review ── --}}
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[#002870]" style="font-size:18px;">info</span>
                </div>
                <h3 class="font-bold text-gray-900 text-base">Info Review</h3>
            </div>
            <div class="p-6 space-y-5">
                {{-- Status --}}
                <div class="space-y-1.5">
                    <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status Saat Ini</small>
                    <span class="px-3 py-1.5 {{ $badgeStyles }} border ring-2 text-xs font-bold uppercase rounded-full tracking-wide inline-block">{{ $application->status_label }}</span>
                </div>

                {{-- Reviewer --}}
                @if($application->reviewer)
                <div class="space-y-1.5">
                    <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Direview oleh</small>
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                            {{ strtoupper(substr($application->reviewer->first_name, 0, 1)) }}
                        </div>
                        <strong class="text-sm text-gray-800">{{ $application->reviewer->full_name }}</strong>
                    </div>
                </div>
                @endif

                {{-- Catatan --}}
                @if($application->review_notes)
                <div class="space-y-1.5">
                    <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Catatan</small>
                    <div class="p-3.5 bg-amber-50 text-amber-800 text-sm rounded-xl border border-amber-100 whitespace-pre-line leading-relaxed">{{ $application->review_notes }}</div>
                </div>
                @endif

                {{-- Terakhir diperbarui --}}
                <div class="space-y-1.5">
                    <small class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Terakhir diperbarui</small>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-gray-400" style="font-size:16px;">schedule</span>
                        <strong class="text-sm text-gray-800">{{ $application->updated_at->format('d M Y, H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
