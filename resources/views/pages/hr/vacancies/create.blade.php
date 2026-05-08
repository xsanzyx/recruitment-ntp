@extends('layouts.hr_tailwind')

@section('title', 'Tambah Lowongan')

@section('content')

{{-- ═══════════════ HEADER ═══════════════ --}}
<div class="max-w-4xl mx-auto">
    <header class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#002870] tracking-tight">Tambah Lowongan</h1>
            <p class="text-gray-500 text-sm mt-1">Buat lowongan kerja baru</p>
        </div>
        <a href="{{ route('hr.vacancies.index') }}"
           class="flex items-center gap-1.5 px-4 py-2 text-[#002870] font-semibold text-sm border border-[#002870]/20 rounded-lg hover:bg-[#002870]/5 transition-all">
            <span class="material-symbols-outlined" style="font-size:16px;">arrow_back</span> Kembali
        </a>
    </header>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-lg shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <span class="material-symbols-outlined text-red-500" style="font-size:20px;">error</span>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Gagal menyimpan lowongan. Silakan periksa kembali:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('hr.vacancies.store') }}" class="space-y-8">
        @csrf

    {{-- ═══ CARD 1: INFORMASI LOWONGAN ═══ --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 sm:px-8 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#002870]" style="font-size:18px;">work</span>
            </div>
            <h3 class="font-bold text-gray-900 text-base">Informasi Lowongan</h3>
        </div>
        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Judul Lowongan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('title') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all" value="{{ old('title') }}" placeholder="cth: Frontend Developer">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department -->
                <div>
                    <label for="department" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Departemen <span class="text-red-500">*</span></label>
                    <input type="text" name="department" id="department" class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('department') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all" value="{{ old('department') }}" placeholder="cth: Engineering">
                    @error('department')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Division -->
                <div>
                    <label for="division" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Divisi <span class="text-red-500">*</span></label>
                    <input type="text" name="division" id="division" class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('division') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all" value="{{ old('division') }}" placeholder="cth: Information Technology">
                    @error('division')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Tipe Pekerjaan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="type" id="type" class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('type') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none appearance-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                            <option value="">Pilih tipe...</option>
                            <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-400 pointer-events-none" style="font-size:18px;">expand_more</span>
                    </div>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Deadline <span class="text-red-500">*</span></label>
                    <input type="date" name="deadline" id="deadline" max="9999-12-31" class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('deadline') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all" value="{{ old('deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    @error('deadline')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    {{-- ═══ CARD 2: DESKRIPSI & PERSYARATAN ═══ --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 sm:px-8 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#002870]" style="font-size:18px;">description</span>
            </div>
            <h3 class="font-bold text-gray-900 text-base">Deskripsi & Persyaratan</h3>
        </div>
        <div class="p-6 sm:p-8 space-y-5">

            <!-- Description -->
            <div>
                <label for="description" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('description') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm outline-none resize-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all" placeholder="Jelaskan tanggung jawab dan lingkup pekerjaan...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Requirements -->
            <div>
                <label for="requirements" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Persyaratan <span class="text-red-500">*</span></label>
                <textarea name="requirements" id="requirements" rows="5" class="w-full px-4 py-3 bg-slate-50 border {{ $errors->has('requirements') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm outline-none resize-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all" placeholder="Tuliskan kualifikasi dan persyaratan kandidat...">{{ old('requirements') }}</textarea>
                @error('requirements')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    {{-- ═══ CARD 3: KRITERIA KELAYAKAN ═══ --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 sm:px-8 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#002870]" style="font-size:18px;">checklist</span>
            </div>
            <h3 class="font-bold text-gray-900 text-base">Kriteria Kelayakan</h3>
        </div>
        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                <!-- Usia Minimal -->
                <div>
                    <label for="min_age" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Usia Minimal <span class="text-red-500">*</span></label>
                    <input type="number" name="min_age" id="min_age" min="15" max="65" class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('min_age') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all" value="{{ old('min_age') }}" placeholder="cth: 18">
                    @error('min_age')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Usia Maksimal -->
                <div>
                    <label for="max_age" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Usia Maksimal <span class="text-red-500">*</span></label>
                    <input type="number" name="max_age" id="max_age" min="15" max="65" class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('max_age') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all" value="{{ old('max_age') }}" placeholder="cth: 35">
                    @error('max_age')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Minimal Pendidikan -->
                <div>
                    <label for="min_education" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Pendidikan Minimal <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="min_education" id="min_education" class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('min_education') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none appearance-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                            <option value="">Pilih Pendidikan</option>
                            <option value="SMA/SMK" {{ old('min_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ old('min_education') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('min_education') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('min_education') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('min_education') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-400 pointer-events-none" style="font-size:18px;">expand_more</span>
                    </div>
                    @error('min_education')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Persyaratan Gender -->
                <div>
                    <label for="gender_requirement" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Persyaratan Jenis Kelamin <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="gender_requirement" id="gender_requirement" class="w-full h-11 px-4 bg-slate-50 border {{ $errors->has('gender_requirement') ? 'border-red-400' : 'border-gray-200' }} rounded-xl text-sm font-medium outline-none appearance-none focus:border-[#002870] focus:ring-2 focus:ring-[#002870]/10 transition-all">
                            <option value="Semua" {{ old('gender_requirement') == 'Semua' ? 'selected' : '' }}>Semua Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender_requirement') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender_requirement') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-400 pointer-events-none" style="font-size:18px;">expand_more</span>
                    </div>
                    @error('gender_requirement')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>
    </div>

    {{-- ═══ SUBMIT ═══ --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('hr.vacancies.index') }}"
           class="flex items-center gap-2 h-11 px-6 border border-gray-200 text-gray-600 font-bold text-sm rounded-xl hover:bg-gray-50 transition-all">
            Batal
        </a>
        <button type="submit"
                class="flex items-center justify-center gap-2 h-11 px-8 bg-[#002870] text-white font-bold text-sm rounded-xl hover:bg-[#001a4d] transition-all shadow-md shadow-blue-900/15 active:scale-[.97]">
            <span class="material-symbols-outlined" style="font-size:16px;">check_circle</span> Simpan Lowongan
        </button>
    </div>

</form>
</div>
@endsection
