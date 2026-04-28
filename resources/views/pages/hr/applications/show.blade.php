@extends('layouts.hr_tailwind')

@section('title', 'Detail Kandidat')

@section('content')
<!-- Header -->
<header class="mb-lg flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
    <div>
        <h1 class="font-h1 text-h1 text-primary-container">Detail Kandidat</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mt-2">{{ $application->user->full_name }}</p>
    </div>
    <a href="{{ route('hr.applications.index') }}" class="flex items-center gap-1 text-[#002870] font-bold text-sm hover:underline">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
    </a>
</header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- LEFT: Applicant Info -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Profile Card -->
        <div class="bg-white border border-outline-variant rounded-xl shadow-sm p-sm sm:p-lg">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full border border-gray-200 flex items-center justify-center bg-[#002870] text-white text-2xl font-bold">
                        {{ strtoupper(substr($application->user->first_name, 0, 1)) }}{{ strtoupper(substr($application->user->last_name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 m-0">{{ $application->user->full_name }}</h2>
                        <span class="text-gray-500 text-sm">{{ $application->user->email }}</span>
                    </div>
                </div>
                <div>
                    @php
                        $badgeColor = 'bg-gray-100 text-gray-700';
                        if($application->status_badge == 'warning') $badgeColor = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                        if($application->status_badge == 'info') $badgeColor = 'bg-blue-50 text-blue-700 border-blue-200';
                        if($application->status_badge == 'success') $badgeColor = 'bg-green-50 text-green-700 border-green-200';
                        if($application->status_badge == 'danger') $badgeColor = 'bg-red-50 text-red-700 border-red-200';
                    @endphp
                    <span class="px-3 py-1.5 {{ $badgeColor }} border text-xs font-bold uppercase rounded-lg">{{ $application->status_label }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-sm">work</span>
                    </div>
                    <div>
                        <small class="block text-xs font-bold text-gray-500 uppercase">Posisi</small>
                        <strong class="text-sm text-gray-900">{{ $application->jobVacancy->title }}</strong>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-sm">domain</span>
                    </div>
                    <div>
                        <small class="block text-xs font-bold text-gray-500 uppercase">Departemen</small>
                        <strong class="text-sm text-gray-900">{{ $application->jobVacancy->department }}</strong>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-sm">calendar_month</span>
                    </div>
                    <div>
                        <small class="block text-xs font-bold text-gray-500 uppercase">Tanggal Melamar</small>
                        <strong class="text-sm text-gray-900">{{ $application->applied_at->format('d M Y, H:i') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Info -->
        <div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                <span class="material-symbols-outlined text-[#002870]">contact_page</span>
                <h3 class="font-bold text-gray-900 m-0">Informasi Pribadi</h3>
            </div>
            <div class="p-6">
                @if($application->user->profile)
                    @php $profile = $application->user->profile; @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <small class="block text-xs font-bold text-gray-500 uppercase mb-1">Pendidikan Terakhir</small>
                            <strong class="text-gray-900">{{ $profile->last_education ?? '—' }}</strong>
                        </div>
                        <div>
                            <small class="block text-xs font-bold text-gray-500 uppercase mb-1">Jenis Kelamin</small>
                            <strong class="text-gray-900">{{ $profile->gender ?? '—' }}</strong>
                        </div>
                        <div>
                            <small class="block text-xs font-bold text-gray-500 uppercase mb-1">No. Telepon</small>
                            <strong class="text-gray-900">{{ $profile->phone ?? '—' }}</strong>
                        </div>
                        <div>
                            <small class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Lahir</small>
                            <strong class="text-gray-900">{{ $profile->birth_date ? $profile->birth_date->format('d M Y') : '—' }}</strong>
                        </div>
                        <div class="sm:col-span-2">
                            <small class="block text-xs font-bold text-gray-500 uppercase mb-1">Alamat</small>
                            <strong class="text-gray-900">{{ $profile->address ?? '—' }}</strong>
                        </div>
                        @if($profile->summary)
                            <div class="sm:col-span-2">
                                <small class="block text-xs font-bold text-gray-500 uppercase mb-1">Ringkasan Profil</small>
                                <p class="text-gray-700 whitespace-pre-line m-0">{{ $profile->summary }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-gray-300 text-6xl">person_off</span>
                        <p class="text-gray-500 mt-2 font-medium">Kandidat belum mengisi profil</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cover Letter -->
        @if($application->cover_letter)
            <div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                    <span class="material-symbols-outlined text-[#002870]">draft</span>
                    <h3 class="font-bold text-gray-900 m-0">Cover Letter</h3>
                </div>
                <div class="p-6">
                    <div class="text-gray-700 whitespace-pre-line">{{ $application->cover_letter }}</div>
                </div>
            </div>
        @endif

        <!-- Resume -->
        @if($application->resume_path)
            <div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                    <span class="material-symbols-outlined text-[#002870]">picture_as_pdf</span>
                    <h3 class="font-bold text-gray-900 m-0">Resume</h3>
                </div>
                <div class="p-6">
                    <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 border border-[#002870] text-[#002870] font-bold rounded-lg hover:bg-blue-50 transition-colors">
                        <span class="material-symbols-outlined">download</span> Download Resume
                    </a>
                </div>
            </div>
        @endif

    </div>

    <!-- RIGHT: Status & Review -->
    <div class="space-y-6">

        <!-- Update Status -->
        <div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                <span class="material-symbols-outlined text-[#002870]">update</span>
                <h3 class="font-bold text-gray-900 m-0">Update Status</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('hr.applications.updateStatus', $application->id) }}">
                    @csrf @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status Baru</label>
                        <select name="status" class="w-full px-4 py-2 border {{ $errors->has('status') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] bg-white">
                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="review" {{ $application->status == 'review' ? 'selected' : '' }}>Sedang Direview</option>
                            <option value="lolos" {{ $application->status == 'lolos' ? 'selected' : '' }}>Lolos</option>
                            <option value="tidak_lolos" {{ $application->status == 'tidak_lolos' ? 'selected' : '' }}>Tidak Lolos</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Catatan Review</label>
                        <textarea name="review_notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870]" placeholder="Tambahkan catatan...">{{ old('review_notes', $application->review_notes) }}</textarea>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-[#002870] text-white font-bold rounded-lg hover:bg-[#001544] transition-colors">
                        <span class="material-symbols-outlined text-sm">check</span> Simpan Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Review History -->
        <div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 bg-gray-50">
                <span class="material-symbols-outlined text-[#002870]">history</span>
                <h3 class="font-bold text-gray-900 m-0">Info Review</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <small class="block text-xs font-bold text-gray-500 uppercase mb-1">Status Saat Ini</small>
                    <span class="px-2 py-1 {{ $badgeColor }} border text-[10px] font-bold uppercase rounded-lg inline-block">{{ $application->status_label }}</span>
                </div>

                @if($application->reviewer)
                    <div>
                        <small class="block text-xs font-bold text-gray-500 uppercase mb-1">Direview oleh</small>
                        <strong class="text-gray-900 text-sm">{{ $application->reviewer->full_name }}</strong>
                    </div>
                @endif

                @if($application->review_notes)
                    <div>
                        <small class="block text-xs font-bold text-gray-500 uppercase mb-1">Catatan</small>
                        <div class="p-3 bg-yellow-50 text-yellow-800 text-sm rounded-lg border border-yellow-100 whitespace-pre-line">{{ $application->review_notes }}</div>
                    </div>
                @endif

                <div>
                    <small class="block text-xs font-bold text-gray-500 uppercase mb-1">Terakhir diperbarui</small>
                    <strong class="text-gray-900 text-sm">{{ $application->updated_at->format('d M Y, H:i') }}</strong>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
