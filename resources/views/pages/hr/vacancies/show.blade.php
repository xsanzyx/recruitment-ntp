@extends('layouts.hr')

@section('title', $vacancy->title)
@section('page-title', 'Detail Lowongan')
@section('page-subtitle', $vacancy->title)

@section('content')

<div class="row g-3">

    {{-- Main Info --}}
    <div class="col-lg-8">
        <div class="hr-card">
            <div class="hr-card-header">
                <h6><i class="bi bi-briefcase me-2"></i>{{ $vacancy->title }}</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('hr.vacancies.edit', $vacancy->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                    </a>
                    <a href="{{ route('hr.vacancies.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="hr-card-body">
                <div class="row g-3 mb-4">
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Departemen</small>
                        <strong>{{ $vacancy->department }}</strong>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Divisi</small>
                        <strong>{{ $vacancy->division }}</strong>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Tipe</small>
                        <strong>{{ ucfirst($vacancy->type) }}</strong>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Deadline</small>
                        <strong>{{ $vacancy->deadline->format('d M Y') }}</strong>
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Status</small>
                        @if($vacancy->isOpen())
                            <span class="badge bg-success">Open</span>
                        @else
                            <span class="badge bg-secondary">Closed</span>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <small class="text-muted d-block">Jumlah Pelamar</small>
                        <strong>{{ $vacancy->applications_count }}</strong>
                    </div>
                </div>

                <hr>

                <h6 class="fw-bold mb-2">Deskripsi Pekerjaan</h6>
                <div class="text-muted mb-4" style="white-space: pre-line;">{{ $vacancy->description }}</div>

                <h6 class="fw-bold mb-2">Persyaratan</h6>
                <div class="text-muted" style="white-space: pre-line;">{{ $vacancy->requirements }}</div>
            </div>
        </div>
    </div>

    {{-- Sidebar Info --}}
    <div class="col-lg-4">
        <div class="hr-card">
            <div class="hr-card-header">
                <h6><i class="bi bi-info-circle me-2"></i>Informasi</h6>
            </div>
            <div class="hr-card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Dibuat pada</small>
                    <strong>{{ $vacancy->created_at->format('d M Y, H:i') }}</strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Terakhir diperbarui</small>
                    <strong>{{ $vacancy->updated_at->format('d M Y, H:i') }}</strong>
                </div>

                <hr>

                {{-- Quick Actions --}}
                <form method="POST" action="{{ route('hr.vacancies.toggle', $vacancy->id) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn {{ $vacancy->isOpen() ? 'btn-outline-danger' : 'btn-outline-success' }} w-100 mb-2">
                        <i class="bi {{ $vacancy->isOpen() ? 'bi-x-circle' : 'bi-check-circle' }} me-1"></i>
                        {{ $vacancy->isOpen() ? 'Tutup Lowongan' : 'Buka Lowongan' }}
                    </button>
                </form>

                <form method="POST" action="{{ route('hr.vacancies.destroy', $vacancy->id) }}"
                      onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash3 me-1"></i> Hapus Lowongan
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
