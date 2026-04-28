@extends('layouts.hr_tailwind')

@section('title', 'Edit Lowongan')

@section('content')
<!-- Header -->
<header class="mb-lg flex justify-between items-end">
    <div>
        <h1 class="font-h1 text-h1 text-primary-container">Edit Lowongan</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mt-2">Perbarui informasi lowongan: {{ $vacancy->title }}</p>
    </div>
    <a href="{{ route('hr.vacancies.index') }}" class="flex items-center gap-1 text-[#002870] font-bold text-sm hover:underline">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
    </a>
</header>

<div class="bg-white border border-outline-variant rounded-xl shadow-sm overflow-hidden max-w-4xl">
    <div class="p-sm sm:p-lg">
        <form method="POST" action="{{ route('hr.vacancies.update', $vacancy->id) }}">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Lowongan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('title', $vacancy->title) }}">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department -->
                <div>
                    <label for="department" class="block text-sm font-bold text-gray-700 mb-1">Departemen <span class="text-red-500">*</span></label>
                    <input type="text" name="department" id="department" class="w-full px-4 py-2 border {{ $errors->has('department') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('department', $vacancy->department) }}">
                    @error('department')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Division -->
                <div>
                    <label for="division" class="block text-sm font-bold text-gray-700 mb-1">Divisi <span class="text-red-500">*</span></label>
                    <input type="text" name="division" id="division" class="w-full px-4 py-2 border {{ $errors->has('division') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('division', $vacancy->division) }}">
                    @error('division')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-bold text-gray-700 mb-1">Tipe Pekerjaan <span class="text-red-500">*</span></label>
                    <select name="type" id="type" class="w-full px-4 py-2 border {{ $errors->has('type') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent bg-white">
                        <option value="full-time" {{ old('type', $vacancy->type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ old('type', $vacancy->type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ old('type', $vacancy->type) == 'contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-bold text-gray-700 mb-1">Deadline <span class="text-red-500">*</span></label>
                    <input type="date" name="deadline" id="deadline" class="w-full px-4 py-2 border {{ $errors->has('deadline') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent" value="{{ old('deadline', $vacancy->deadline->format('Y-m-d')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    @error('deadline')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="5" class="w-full px-4 py-2 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent">{{ old('description', $vacancy->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Requirements -->
                <div class="md:col-span-2">
                    <label for="requirements" class="block text-sm font-bold text-gray-700 mb-1">Persyaratan <span class="text-red-500">*</span></label>
                    <textarea name="requirements" id="requirements" rows="5" class="w-full px-4 py-2 border {{ $errors->has('requirements') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-[#002870] focus:border-transparent">{{ old('requirements', $vacancy->requirements) }}</textarea>
                    @error('requirements')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('hr.vacancies.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="flex items-center gap-2 px-6 py-2 bg-[#002870] text-white font-bold rounded-lg hover:bg-[#001544] transition-colors">
                    <span class="material-symbols-outlined text-sm">check</span> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
