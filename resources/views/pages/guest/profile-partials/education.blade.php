{{-- ═══ RIWAYAT PENDIDIKAN ═══ --}}
<div class="fade-up mb-4" style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 style="font-weight:700;color:var(--primary-color);margin:0;">Riwayat Pendidikan</h5>
        <button type="button" class="btn btn-secondary-custom btn-sm px-3" id="add-edu" style="border-radius:8px;font-size:13px;">
            <i class="bi bi-plus me-1"></i>Tambah
        </button>
    </div>

    <div id="edu-list" class="d-flex flex-column gap-3">
        @php $eduData = old('education', $profile->education ?? []); @endphp
        @if(!empty($eduData))
            @foreach($eduData as $i => $edu)
            <div class="edu-entry" style="background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;position:relative;">
                @if($i > 0)
                <button type="button" class="btn-remove-entry" onclick="this.closest('.edu-entry').remove()" style="position:absolute;top:10px;right:10px;background:none;border:none;color:#ef4444;font-size:18px;cursor:pointer;">
                    <i class="bi bi-x-lg"></i>
                </button>
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="apply-label">Jenjang *</label>
                        <select name="education[{{ $i }}][level]" class="apply-input">
                            <option value="">Pilih</option>
                            @foreach(['SMA/SMK','D3','S1','S2','S3'] as $lvl)
                            <option value="{{ $lvl }}" {{ ($edu['level'] ?? '') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Nama Institusi *</label>
                        <input type="text" name="education[{{ $i }}][institution]" class="apply-input" placeholder="Universitas / Sekolah" value="{{ $edu['institution'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Jurusan / Program Studi</label>
                        <input type="text" name="education[{{ $i }}][major]" class="apply-input" placeholder="Teknik Informatika" value="{{ $edu['major'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">Tahun Masuk</label>
                        <input type="number" name="education[{{ $i }}][year_start]" class="apply-input year-input" placeholder="2018" min="1900" max="2030" value="{{ $edu['year_start'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">Tahun Lulus</label>
                        <input type="number" name="education[{{ $i }}][year_end]" class="apply-input year-input" placeholder="2022" min="1900" max="2030" value="{{ $edu['year_end'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">IPK / Nilai Akhir *</label>
                        <input type="text" name="education[{{ $i }}][gpa]" class="apply-input" placeholder="3.75" value="{{ $edu['gpa'] ?? '' }}">
                    </div>
                </div>
            </div>
            @endforeach
        @else
            {{-- Default 1 entry kosong --}}
            <div class="edu-entry" style="background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="apply-label">Jenjang *</label>
                        <select name="education[0][level]" class="apply-input">
                            <option value="">Pilih</option>
                            <option value="SMA/SMK">SMA/SMK</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Nama Institusi *</label>
                        <input type="text" name="education[0][institution]" class="apply-input" placeholder="Universitas / Sekolah">
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Jurusan / Program Studi</label>
                        <input type="text" name="education[0][major]" class="apply-input" placeholder="Teknik Informatika">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">Tahun Masuk</label>
                        <input type="number" name="education[0][year_start]" class="apply-input year-input" placeholder="2018" min="1900" max="2030">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">Tahun Lulus</label>
                        <input type="number" name="education[0][year_end]" class="apply-input year-input" placeholder="2022" min="1900" max="2030">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">IPK / Nilai Akhir *</label>
                        <input type="text" name="education[0][gpa]" class="apply-input" placeholder="3.75">
                    </div>
                </div>
            </div>
        @endif
    </div>

    <small class="text-muted d-block mt-2" style="font-size:11px;">
        <i class="bi bi-info-circle me-1"></i>Untuk kolom IPK: masukkan IPK (jika mahasiswa/lulusan perguruan tinggi) atau Nilai Akhir/rata-rata rapor (jika lulusan SMA/SMK). Contoh: 3.75 atau 85.5
    </small>
</div>
