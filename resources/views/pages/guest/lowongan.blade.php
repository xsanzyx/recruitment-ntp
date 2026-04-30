@extends('layouts.main')

@section('content')

<section class="jobs-section" style="padding-top: 100px;">
    <div class="container">
                {{-- Flash Message --}}
                @if(session('success'))
                <div class="fade-up mb-4" style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);border-radius:12px;padding:14px 18px;color:#166534;">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="fade-up mb-4" style="background:rgba(186,26,26,0.08);border:1px solid rgba(186,26,26,0.2);border-radius:12px;padding:14px 18px;color:#ba1a1a;">
                    <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                </div>
                @endif

        {{-- Header --}}
        <div class="fade-up mb-5">
            <small class="section-label"><i class="bi bi-briefcase me-2"></i>Lowongan Terbuka</small>
            <h1 class="hero-title mt-2">Temukan peran yang cocok untukmu</h1>
            <p class="hero-subtitle">Cari berdasarkan posisi atau skill, lalu saring berdasarkan departemen, divisi, dan tipe pekerjaan.</p>
        </div>

        {{-- Search & Filter --}}
        <div class="fade-up mb-4">
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <div class="search-bar flex-grow-1" style="max-width: 460px;">
                    <i class="bi bi-search"></i>
                    <input type="text" id="search-input" placeholder="Cari posisi, skill, departemen, atau divisi">
                </div>
                <select class="form-select" id="filter-dept" style="max-width: 220px; border-radius: 10px; border: 1px solid #e5e7eb; padding: 10px 14px; font-size: 14px;">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
                <select class="form-select" id="filter-divisi" style="max-width: 220px; border-radius: 10px; border: 1px solid #e5e7eb; padding: 10px 14px; font-size: 14px;">
                    <option value="">Semua Divisi</option>
                    @foreach($divisions as $div)
                        <option value="{{ $div }}">{{ $div }}</option>
                    @endforeach
                </select>
                <select class="form-select" id="filter-tipe" style="max-width: 180px; border-radius: 10px; border: 1px solid #e5e7eb; padding: 10px 14px; font-size: 14px;">
                    <option value="">Semua Tipe</option>
                    <option value="full-time">Full-Time</option>
                    <option value="part-time">Part-Time</option>
                    <option value="contract">Contract</option>
                </select>
            </div>
        </div>

        {{-- Job List --}}
        <div class="d-flex flex-column gap-3" id="job-list">

            @forelse($vacancies as $vacancy)
            <div class="job-card fade-up" 
                 data-dept="{{ $vacancy->department }}" 
                 data-divisi="{{ $vacancy->division }}" 
                 data-tipe="{{ $vacancy->type }}">
                <div class="job-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="job-icon {{ $loop->first ? 'primary-bg' : 'light-bg' }}"><i class="bi bi-briefcase"></i></div>
                        <div>
                            <strong style="font-size:16px;color:var(--primary-color);">{{ $vacancy->title }}</strong><br>
                            <small style="color:#64748b;">{{ $vacancy->division }} · {{ $vacancy->department }} · {{ ucfirst($vacancy->type) }}</small>
                        </div>
                    </div>
                    <small class="toggle-text" style="color:var(--primary-color);cursor:pointer;">Lihat detail <i class="bi bi-chevron-down"></i></small>
                </div>
                <div class="job-detail">
                    <div class="job-detail-inner">
                        <div class="row g-4 mb-4">
                            <div class="col-md-7">
                                <h6 style="font-weight:600;color:var(--primary-color);margin-bottom:12px;">Kualifikasi:</h6>
                                <ul style="color:#64748b;font-size:14px;padding-left:20px;">
                                    @foreach(array_filter(array_map('trim', explode("\n", $vacancy->requirements))) as $req)
                                        @if($req)
                                        <li class="mb-1">{{ $req }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="job-info-box">
                                    <div class="job-info-row">
                                        <span class="job-info-label">Departemen</span>
                                        <span class="job-info-value">{{ $vacancy->department }}</span>
                                    </div>
                                    <div class="job-info-row" style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;">
                                        <span class="job-info-label">Divisi</span>
                                        <span class="job-info-value">{{ $vacancy->division }}</span>
                                    </div>
                                    <div class="job-info-row" style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;">
                                        <span class="job-info-label">Tipe</span>
                                        <span class="job-info-value">{{ ucfirst($vacancy->type) }}</span>
                                    </div>
                                    <div class="job-info-row" style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;">
                                        <span class="job-info-label">Deadline</span>
                                        <span class="job-info-value">{{ $vacancy->deadline->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @auth
                        @php
                            $alreadyApplied = auth()->user()->applications()
                                    ->where('job_vacancy_id', $vacancy->id)
                                    ->exists();
                        @endphp

                        @if($alreadyApplied)
                            <button class="btn px-4 py-2" disabled
                                style="border-radius:10px;font-size:14px;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;cursor:not-allowed;">
                                <i class="bi bi-check-circle me-2"></i>Sudah Melamar
                            </button>
                        @else
                            <a href="{{ route('apply.create', $vacancy->id) }}"
                            class="btn btn-secondary-custom px-4 py-2"
                            style="border-radius:10px;font-size:14px;">
                                Lamar Sekarang
                            </a>
                        @endif
                        @else
                            <a href="{{ route('login') }}"
                            class="btn btn-secondary-custom px-4 py-2"
                            style="border-radius:10px;font-size:14px;">
                                Login untuk Melamar
                            </a>
                    @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-search" style="font-size:40px;color:#cbd5e1;"></i>
                <p class="mt-3 text-muted">Belum ada lowongan yang tersedia saat ini.</p>
            </div>
            @endforelse

        </div>

        {{-- Empty state (for JS filter) --}}
        <div id="empty-state" class="text-center py-5" style="display:none;">
            <i class="bi bi-search" style="font-size:40px;color:#cbd5e1;"></i>
            <p class="mt-3 text-muted">Tidak ada lowongan yang cocok dengan pencarianmu.</p>
        </div>

    </div>
</section>

@include('components.footer')

@endsection

@push('scripts')
<script>
    const searchInput  = document.getElementById('search-input');
    const filterDept   = document.getElementById('filter-dept');
    const filterDivisi = document.getElementById('filter-divisi');
    const filterTipe   = document.getElementById('filter-tipe');
    const cards        = document.querySelectorAll('#job-list .job-card');
    const emptyState   = document.getElementById('empty-state');

    function filterJobs() {
        const q      = searchInput.value.toLowerCase();
        const dept   = filterDept.value.toLowerCase();
        const divisi = filterDivisi.value.toLowerCase();
        const tipe   = filterTipe.value.toLowerCase();
        let visible  = 0;

        cards.forEach(card => {
            const text      = card.innerText.toLowerCase();
            const cardDept  = (card.dataset.dept   || '').toLowerCase();
            const cardDiv   = (card.dataset.divisi || '').toLowerCase();
            const cardTipe  = (card.dataset.tipe   || '').toLowerCase();

            const matchQ    = !q      || text.includes(q);
            const matchDept = !dept   || cardDept.includes(dept);
            const matchDiv  = !divisi || cardDiv.includes(divisi);
            const matchTipe = !tipe   || cardTipe.includes(tipe);

            if (matchQ && matchDept && matchDiv && matchTipe) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        emptyState.style.display = visible === 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input',  filterJobs);
    filterDept.addEventListener('change',  filterJobs);
    filterDivisi.addEventListener('change', filterJobs);
    filterTipe.addEventListener('change',  filterJobs);
</script>
@endpush