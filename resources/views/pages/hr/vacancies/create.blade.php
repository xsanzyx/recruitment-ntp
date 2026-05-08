@extends('layouts.hr_tailwind')

@section('title', 'Tambah Lowongan')

@section('content')
<!-- Header -->
<header class="mb-lg flex justify-between items-end">
    <div>
        <h1 class="font-h1 text-h1 text-primary-container">Tambah Lowongan</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mt-2">Buat lowongan kerja baru</p>
    </div>
    <a href="{{ route('hr.vacancies.index') }}" class="flex items-center gap-1 text-[#002870] font-bold text-sm hover:underline">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
    </a>
</header>

<div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden max-w-4xl">
    <div class="p-sm sm:p-lg">
        <form method="POST" action="{{ route('hr.vacancies.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Lowongan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('title') }}" placeholder="cth: Frontend Developer">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department -->
                <div>
                    <label for="department" class="block text-sm font-bold text-gray-700 mb-1">Departemen <span class="text-red-500">*</span></label>
                    <input type="text" name="department" id="department" class="w-full px-4 py-2 border {{ $errors->has('department') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('department') }}" placeholder="cth: Engineering">
                    @error('department')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Division -->
                <div>
                    <label for="division" class="block text-sm font-bold text-gray-700 mb-1">Divisi <span class="text-red-500">*</span></label>
                    <input type="text" name="division" id="division" class="w-full px-4 py-2 border {{ $errors->has('division') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('division') }}" placeholder="cth: Information Technology">
                    @error('division')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-bold text-gray-700 mb-1">Tipe Pekerjaan <span class="text-red-500">*</span></label>
                    <select name="type" id="type" class="w-full px-4 py-2 border {{ $errors->has('type') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent bg-white">
                        <option value="">Pilih tipe...</option>
                        <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-bold text-gray-700 mb-1">Deadline <span class="text-red-500">*</span></label>
                    <input type="date" name="deadline" id="deadline" class="w-full px-4 py-2 border {{ $errors->has('deadline') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    @error('deadline')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" placeholder="Jelaskan tanggung jawab dan lingkup pekerjaan...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Requirements -->
                <div class="md:col-span-2">
                    <label for="requirements" class="block text-sm font-bold text-gray-700 mb-1">Persyaratan <span class="text-red-500">*</span></label>
                    <textarea name="requirements" id="requirements" rows="5" class="w-full px-4 py-2 border {{ $errors->has('requirements') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" placeholder="Tuliskan kualifikasi dan persyaratan kandidat...">{{ old('requirements') }}</textarea>
                    @error('requirements')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Kriteria Kelayakan (Eligibility) -->
            <div class="mt-8 pt-6 border-t border-gray-100">
                <h3 class="text-lg font-bold text-[#002870] mb-4">Kriteria Kelayakan <span class="text-red-500">*</span></h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Usia Minimal -->
                    <div>
                        <label for="min_age" class="block text-sm font-bold text-gray-700 mb-1">Usia Minimal <span class="text-red-500">*</span></label>
                        <input type="number" name="min_age" id="min_age" min="15" max="65" class="w-full px-4 py-2 border {{ $errors->has('min_age') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('min_age') }}" placeholder="cth: 18">
                        @error('min_age')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usia Maksimal -->
                    <div>
                        <label for="max_age" class="block text-sm font-bold text-gray-700 mb-1">Usia Maksimal <span class="text-red-500">*</span></label>
                        <input type="number" name="max_age" id="max_age" min="15" max="65" class="w-full px-4 py-2 border {{ $errors->has('max_age') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('max_age') }}" placeholder="cth: 35">
                        @error('max_age')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Minimal Pendidikan -->
                    <div>
                        <label for="min_education" class="block text-sm font-bold text-gray-700 mb-1">Pendidikan Minimal <span class="text-red-500">*</span></label>
                        <select name="min_education" id="min_education" class="w-full px-4 py-2 border {{ $errors->has('min_education') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent bg-white">
                            <option value="">Semua Pendidikan</option>
                            <option value="SMA/SMK" {{ old('min_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ old('min_education') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('min_education') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('min_education') == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('min_education') == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('min_education')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Persyaratan Gender -->
                    <div>
                        <label for="gender_requirement" class="block text-sm font-bold text-gray-700 mb-1">Persyaratan Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="gender_requirement" id="gender_requirement" class="w-full px-4 py-2 border {{ $errors->has('gender_requirement') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent bg-white">
                            <option value="Semua" {{ old('gender_requirement') == 'Semua' ? 'selected' : '' }}>Semua Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender_requirement') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender_requirement') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender_requirement')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('hr.vacancies.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="flex items-center gap-2 px-6 py-2 bg-[#002870] text-white font-bold rounded-lg hover:bg-[#001544] transition-colors">
                    <span class="material-symbols-outlined text-sm">check</span> Simpan Lowongan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
