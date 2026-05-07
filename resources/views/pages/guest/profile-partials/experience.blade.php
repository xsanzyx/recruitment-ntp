{{-- ═══ PENGALAMAN KERJA ═══ --}}
<div class="fade-up mb-4" style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 style="font-weight:700;color:var(--primary-color);margin:0;">Pengalaman Kerja</h5>
        <button type="button" class="btn btn-secondary-custom btn-sm px-3" id="add-exp" style="border-radius:8px;font-size:13px;">
            <i class="bi bi-plus me-1"></i>Tambah
        </button>
    </div>
    <p style="font-size:13px;color:#64748b;margin-bottom:16px;">Kosongkan jika belum memiliki pengalaman kerja.</p>

    <div id="exp-list" class="d-flex flex-column gap-3">
        @php $expData = old('experience', $profile->experience ?? []); @endphp
        @if(!empty($expData))
            @foreach($expData as $i => $exp)
            <div class="exp-entry" style="background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;position:relative;">
                <button type="button" class="btn-remove-entry" onclick="this.closest('.exp-entry').remove()" style="position:absolute;top:10px;right:10px;background:none;border:none;color:#ef4444;font-size:18px;cursor:pointer;">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="apply-label">Posisi / Jabatan</label>
                        <input type="text" name="experience[{{ $i }}][position]" class="apply-input" placeholder="Software Engineer" value="{{ $exp['position'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Nama Perusahaan</label>
                        <input type="text" name="experience[{{ $i }}][company]" class="apply-input" placeholder="PT Contoh Indonesia" value="{{ $exp['company'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">Tahun Mulai</label>
                        <input type="number" name="experience[{{ $i }}][year_start]" class="apply-input year-input" placeholder="2020" min="1900" max="2030" value="{{ $exp['year_start'] ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">Tahun Selesai</label>
                        <input type="number" name="experience[{{ $i }}][year_end]" class="apply-input year-input exp-year-end" placeholder="2023" min="1900" max="2030" value="{{ $exp['year_end'] ?? '' }}" {{ !empty($exp['current']) ? 'disabled' : '' }}>
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Masih Bekerja?</label>
                        <select name="experience[{{ $i }}][current]" class="apply-input exp-current-toggle" onchange="toggleYearEnd(this)">
                            <option value="0" {{ empty($exp['current']) ? 'selected' : '' }}>Tidak</option>
                            <option value="1" {{ !empty($exp['current']) ? 'selected' : '' }}>Ya (masih aktif)</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="apply-label">Deskripsi Pekerjaan</label>
                        <textarea name="experience[{{ $i }}][description]" class="apply-input" rows="3" placeholder="Jelaskan tanggung jawab dan pencapaian kamu...">{{ $exp['description'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="exp-entry" style="background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="apply-label">Posisi / Jabatan</label>
                        <input type="text" name="experience[0][position]" class="apply-input" placeholder="Software Engineer">
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Nama Perusahaan</label>
                        <input type="text" name="experience[0][company]" class="apply-input" placeholder="PT Contoh Indonesia">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">Tahun Mulai</label>
                        <input type="number" name="experience[0][year_start]" class="apply-input year-input" placeholder="2020" min="1900" max="2030">
                    </div>
                    <div class="col-md-3">
                        <label class="apply-label">Tahun Selesai</label>
                        <input type="number" name="experience[0][year_end]" class="apply-input year-input exp-year-end" placeholder="2023" min="1900" max="2030">
                    </div>
                    <div class="col-md-6">
                        <label class="apply-label">Masih Bekerja?</label>
                        <select name="experience[0][current]" class="apply-input exp-current-toggle" onchange="toggleYearEnd(this)">
                            <option value="0">Tidak</option>
                            <option value="1">Ya (masih aktif)</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="apply-label">Deskripsi Pekerjaan</label>
                        <textarea name="experience[0][description]" class="apply-input" rows="3" placeholder="Jelaskan tanggung jawab dan pencapaian kamu..."></textarea>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
