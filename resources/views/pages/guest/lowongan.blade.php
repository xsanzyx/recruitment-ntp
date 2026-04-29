@extends('layouts.main')

@section('content')

<section class="jobs-section" style="padding-top: 100px;">
    <div class="container">

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
                    <option value="Management Information System">Management Information System</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Finance">Finance</option>
                    <option value="Human Resources">Human Resources</option>
                    <option value="Business Development">Business Development</option>
                </select>
                <select class="form-select" id="filter-divisi" style="max-width: 220px; border-radius: 10px; border: 1px solid #e5e7eb; padding: 10px 14px; font-size: 14px;">
                    <option value="">Semua Divisi</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Design & User Experience">Design & User Experience</option>
                    <option value="Business Development">Business Development</option>
                </select>
                <select class="form-select" id="filter-tipe" style="max-width: 180px; border-radius: 10px; border: 1px solid #e5e7eb; padding: 10px 14px; font-size: 14px;">
                    <option value="">Semua Tipe</option>
                    <option value="Full-Time">Full-Time</option>
                    <option value="Part-Time">Part-Time</option>
                    <option value="Internship">Internship</option>
                </select>
            </div>
        </div>

        {{-- Job List --}}
        <div class="d-flex flex-column gap-3" id="job-list">

            <div class="job-card fade-up" 
                 data-dept="Management Information System" 
                 data-divisi="Information Technology" 
                 data-tipe="Full-Time">
                <div class="job-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="job-icon primary-bg"><i class="bi bi-code-slash"></i></div>
                        <div>
                            <strong style="font-size:16px;color:var(--primary-color);">Software Engineer</strong><br>
                            <small style="color:#64748b;">Information Technology · Management Information System · Full-Time</small>
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
                                    <li class="mb-1">Pendidikan S1 Teknik Informatika atau setara.</li>
                                    <li class="mb-1">Pengalaman minimal 2 tahun dalam pengembangan aplikasi.</li>
                                    <li class="mb-1">Menguasai bahasa pemrograman Java, Python, atau Go.</li>
                                    <li class="mb-1">Memahami konsep Microservices dan RESTful API.</li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="job-info-box">
                                    <div class="job-info-row">
                                        <span class="job-info-label">Departemen</span>
                                        <span class="job-info-value">Management Information System</span>
                                    </div>
                                    <div class="job-info-row" style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;">
                                        <span class="job-info-label">Divisi</span>
                                        <span class="job-info-value">Information Technology</span>
                                    </div>
                                    <div class="job-info-row" style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;">
                                        <span class="job-info-label">Tipe</span>
                                        <span class="job-info-value">Full-Time</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @auth
                            <button class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;font-size:14px;">Lamar Sekarang</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;font-size:14px;">Login untuk Melamar</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="job-card fade-up" 
                 data-dept="Management Information System" 
                 data-divisi="Design & User Experience" 
                 data-tipe="Full-Time">
                <div class="job-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="job-icon light-bg"><i class="bi bi-palette-fill"></i></div>
                        <div>
                            <strong style="font-size:16px;color:var(--primary-color);">UI/UX Designer</strong><br>
                            <small style="color:#64748b;">Design & User Experience · Management Information System · Full-Time</small>
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
                                    <li class="mb-1">Pendidikan S1 Desain Komunikasi Visual atau setara.</li>
                                    <li class="mb-1">Menguasai Figma, Adobe XD, atau Sketch.</li>
                                    <li class="mb-1">Pemahaman design system dan design thinking.</li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="job-info-box">
                                    <div class="job-info-row">
                                        <span class="job-info-label">Departemen</span>
                                        <span class="job-info-value">Management Information System</span>
                                    </div>
                                    <div class="job-info-row" style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;">
                                        <span class="job-info-label">Divisi</span>
                                        <span class="job-info-value">Design & User Experience</span>
                                    </div>
                                    <div class="job-info-row" style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;">
                                        <span class="job-info-label">Tipe</span>
                                        <span class="job-info-value">Full-Time</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @auth
                            <button class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;font-size:14px;">Lamar Sekarang</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;font-size:14px;">Login untuk Melamar</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="job-card fade-up" 
                 data-dept="Business Development" 
                 data-divisi="Business Development" 
                 data-tipe="Full-Time">
                <div class="job-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="job-icon light-bg"><i class="bi bi-megaphone-fill"></i></div>
                        <div>
                            <strong style="font-size:16px;color:var(--primary-color);">Marketing Executive</strong><br>
                            <small style="color:#64748b;">Business Development · Business Development · Full-Time</small>
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
                                    <li class="mb-1">Pendidikan S1 Marketing / Manajemen Bisnis.</li>
                                    <li class="mb-1">Pengalaman minimal 3 tahun di bidang pemasaran B2B.</li>
                                    <li class="mb-1">Kemampuan komunikasi dan negosiasi yang kuat.</li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="job-info-box">
                                    <div class="job-info-row">
                                        <span class="job-info-label">Departemen</span>
                                        <span class="job-info-value">Business Development</span>
                                    </div>
                                    <div class="job-info-row" style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;">
                                        <span class="job-info-label">Divisi</span>
                                        <span class="job-info-value">Business Development</span>
                                    </div>
                                    <div class="job-info-row" style="border-top:1px solid #e5e7eb;margin-top:8px;padding-top:8px;">
                                        <span class="job-info-label">Tipe</span>
                                        <span class="job-info-value">Full-Time</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @auth
                            <button class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;font-size:14px;">Lamar Sekarang</button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary-custom px-4 py-2" style="border-radius:10px;font-size:14px;">Login untuk Melamar</a>
                        @endauth
                    </div>
                </div>
            </div>

        </div>

        {{-- Empty state --}}
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