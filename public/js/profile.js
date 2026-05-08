// ═══════════════════════════════════════
//  PROFILE PAGE JS
// ═══════════════════════════════════════

// ── Avatar Crop ──
let cropper = null;
const avatarInput = document.getElementById('avatar-input');
const cropModal   = document.getElementById('crop-modal');
const cropImage   = document.getElementById('crop-image');
const cropCancel  = document.getElementById('crop-cancel');
const cropConfirm = document.getElementById('crop-confirm');

if (avatarInput) {
    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2MB.');
            this.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            cropImage.src = e.target.result;
            cropModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            if (cropper) cropper.destroy();
            cropper = new Cropper(cropImage, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                movable: true,
                zoomable: true,
                rotatable: false,
            });
        };
        reader.readAsDataURL(file);
    });
}

if (cropCancel) {
    cropCancel.addEventListener('click', () => {
        cropModal.style.display = 'none';
        document.body.style.overflow = '';
        if (cropper) cropper.destroy();
        avatarInput.value = '';
    });
}

if (cropConfirm) {
    cropConfirm.addEventListener('click', () => {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
        const base64 = canvas.toDataURL('image/jpeg', 0.85);
        document.getElementById('avatar-cropped').value = base64;
        document.getElementById('avatar-preview').innerHTML =
            `<img src="${base64}" style="width:100%;height:100%;object-fit:cover;">`;
        cropModal.style.display = 'none';
        document.body.style.overflow = '';
        cropper.destroy();
    });
}

// ── Bio Counter ──
const bioEl    = document.querySelector('[name="bio"]');
const bioCount = document.getElementById('bio-count');
if (bioEl && bioCount) {
    bioEl.addEventListener('input', () => {
        bioCount.textContent = bioEl.value.length + '/500';
    });
}

// ── Add Education Entry ──
const addEduBtn = document.getElementById('add-edu');
if (addEduBtn) {
    addEduBtn.addEventListener('click', () => {
        const list = document.getElementById('edu-list');
        const idx = list.querySelectorAll('.edu-entry').length;
        const html = `
        <div class="edu-entry" style="background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;position:relative;">
            <button type="button" class="btn-remove-entry" onclick="this.closest('.edu-entry').remove()" style="position:absolute;top:10px;right:10px;background:none;border:none;color:#ef4444;font-size:18px;cursor:pointer;">
                <i class="bi bi-x-lg"></i>
            </button>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="apply-label">Jenjang *</label>
                    <select name="education[${idx}][level]" class="apply-input">
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
                    <input type="text" name="education[${idx}][institution]" class="apply-input" placeholder="Universitas / Sekolah">
                </div>
                <div class="col-md-6">
                    <label class="apply-label">Jurusan / Program Studi</label>
                    <input type="text" name="education[${idx}][major]" class="apply-input" placeholder="Teknik Informatika">
                </div>
                <div class="col-md-3">
                    <label class="apply-label">Tahun Masuk</label>
                    <input type="number" name="education[${idx}][year_start]" class="apply-input year-input" placeholder="2018" min="1900" max="2030">
                </div>
                <div class="col-md-3">
                    <label class="apply-label">Tahun Lulus</label>
                    <input type="number" name="education[${idx}][year_end]" class="apply-input year-input" placeholder="2022" min="1900" max="2030">
                </div>
                <div class="col-md-3">
                    <label class="apply-label">IPK / Nilai Akhir *</label>
                    <input type="text" name="education[${idx}][gpa]" class="apply-input" placeholder="3.75">
                </div>
            </div>
        </div>`;
        list.insertAdjacentHTML('beforeend', html);
    });
}

// ── Add Experience Entry ──
const addExpBtn = document.getElementById('add-exp');
if (addExpBtn) {
    addExpBtn.addEventListener('click', () => {
        const list = document.getElementById('exp-list');
        const idx = list.querySelectorAll('.exp-entry').length;
        const html = `
        <div class="exp-entry" style="background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;position:relative;">
            <button type="button" class="btn-remove-entry" onclick="this.closest('.exp-entry').remove()" style="position:absolute;top:10px;right:10px;background:none;border:none;color:#ef4444;font-size:18px;cursor:pointer;">
                <i class="bi bi-x-lg"></i>
            </button>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="apply-label">Posisi / Jabatan</label>
                    <input type="text" name="experience[${idx}][position]" class="apply-input" placeholder="Software Engineer">
                </div>
                <div class="col-md-6">
                    <label class="apply-label">Nama Perusahaan</label>
                    <input type="text" name="experience[${idx}][company]" class="apply-input" placeholder="PT Contoh Indonesia">
                </div>
                <div class="col-md-3">
                    <label class="apply-label">Tahun Mulai</label>
                    <input type="number" name="experience[${idx}][year_start]" class="apply-input year-input" placeholder="2020" min="1900" max="2030">
                </div>
                <div class="col-md-3">
                    <label class="apply-label">Tahun Selesai</label>
                    <input type="number" name="experience[${idx}][year_end]" class="apply-input year-input exp-year-end" placeholder="2023" min="1900" max="2030">
                </div>
                <div class="col-md-6">
                    <label class="apply-label">Masih Bekerja?</label>
                    <select name="experience[${idx}][current]" class="apply-input exp-current-toggle" onchange="toggleYearEnd(this)">
                        <option value="0">Tidak</option>
                        <option value="1">Ya (masih aktif)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="apply-label">Deskripsi Pekerjaan</label>
                    <textarea name="experience[${idx}][description]" class="apply-input" rows="3" placeholder="Jelaskan tanggung jawab dan pencapaian kamu..."></textarea>
                </div>
            </div>
        </div>`;
        list.insertAdjacentHTML('beforeend', html);
    });
}

// ── Toggle "Masih Bekerja" → disable Tahun Selesai ──
function toggleYearEnd(selectEl) {
    const entry = selectEl.closest('.exp-entry');
    const yearEnd = entry.querySelector('.exp-year-end');
    if (selectEl.value === '1') {
        yearEnd.disabled = true;
        yearEnd.value = '';
        yearEnd.style.opacity = '0.5';
    } else {
        yearEnd.disabled = false;
        yearEnd.style.opacity = '1';
    }
}

// ── CV Upload Preview ──
const cvInput = document.getElementById('cv-input');
const cvName  = document.getElementById('cv-name');
if (cvInput && cvName) {
    cvInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            cvName.style.display = 'block';
            cvName.querySelector('span').textContent = file.name;
        } else {
            cvName.style.display = 'none';
        }
    });
}

// ── Docs Upload Preview (Accumulative) ──
const docsInput = document.getElementById('docs-input');
const docsList  = document.getElementById('docs-list');
let accumulatedDocs = new DataTransfer();

if (docsInput && docsList) {
    docsInput.addEventListener('change', function(e) {
        // Prevent infinite loop from our own dispatch
        if (!e.isTrusted && e.detail === 'renderOnly') return;
        
        // Add new files to accumulated
        if (e.isTrusted) {
            Array.from(this.files).forEach(f => {
                accumulatedDocs.items.add(f);
            });
            // Update the input files
            docsInput.files = accumulatedDocs.files;
        }

        docsList.innerHTML = '';
        Array.from(docsInput.files).forEach((f, index) => {
            docsList.innerHTML += `
            <div class="d-flex align-items-center justify-content-between" style="padding:8px 14px;background:#f0fdf4;border-radius:8px;border:1px solid #bbf7d0;font-size:13px;color:#166534;margin-bottom:8px;">
                <div style="word-break: break-all; padding-right:10px;"><i class="bi bi-check-circle me-2"></i>${f.name}</div>
                <button type="button" class="btn-remove-doc" data-index="${index}" style="background:none;border:none;color:#ef4444;cursor:pointer;padding:0;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>`;
        });
    });

    // Remove file logic
    docsList.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-remove-doc');
        if (btn) {
            const indexToRemove = parseInt(btn.getAttribute('data-index'));
            let newDocs = new DataTransfer();
            
            Array.from(docsInput.files).forEach((f, index) => {
                if (index !== indexToRemove) {
                    newDocs.items.add(f);
                }
            });
            
            accumulatedDocs = newDocs;
            docsInput.files = accumulatedDocs.files;
            
            // Re-render
            docsInput.dispatchEvent(new CustomEvent('change', { detail: 'renderOnly' }));
            
            // Trigger main form tracking
            const profileForm = document.getElementById('profile-form');
            if (profileForm) {
                profileForm.dispatchEvent(new Event('change'));
            }
        }
    });
}

// ── Limit Year Inputs to 4 Digits ──
document.addEventListener('input', function(e) {
    if (e.target && e.target.classList.contains('year-input')) {
        if (e.target.value.length > 4) {
            e.target.value = e.target.value.slice(0, 4);
        }
    }
});

// ── Track Form Changes ──
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profile-form');
    const saveBtn = document.getElementById('btn-save-profile');
    
    if (profileForm && saveBtn) {
        // Only track if the button is currently disabled
        if (saveBtn.disabled) {
            profileForm.addEventListener('input', activateSaveBtn);
            profileForm.addEventListener('change', activateSaveBtn);
        }

        function activateSaveBtn() {
            saveBtn.disabled = false;
            saveBtn.className = 'btn btn-secondary-custom px-4 py-2';
            saveBtn.style.background = '';
            saveBtn.style.borderColor = '';
            saveBtn.style.color = '';
            
            // Remove listeners once activated
            profileForm.removeEventListener('input', activateSaveBtn);
            profileForm.removeEventListener('change', activateSaveBtn);
        }
        
        // Also activate if crop confirm or add edu/exp is clicked
        if (cropConfirm) cropConfirm.addEventListener('click', activateSaveBtn);
        if (addEduBtn) addEduBtn.addEventListener('click', activateSaveBtn);
        if (addExpBtn) addExpBtn.addEventListener('click', activateSaveBtn);
    }
});