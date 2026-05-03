// =============================================
//  APPLY FORM — Multi Step
// =============================================

let currentStep = 0;
const totalSteps = 4;

const steps     = document.querySelectorAll('.step-content');
const pills     = document.querySelectorAll('.step-pill');
const btnNext   = document.getElementById('btn-next');
const btnPrev   = document.getElementById('btn-prev');
const btnSubmit = document.getElementById('btn-submit');

function goToStep(step) {
    steps.forEach((s, i) => s.style.display = i === step ? 'block' : 'none');
    pills.forEach((p, i) => {
        p.classList.toggle('active', i === step);
        p.classList.toggle('done', i < step);
    });
    btnPrev.style.display   = step > 0 ? 'inline-flex' : 'none';
    btnNext.style.display   = step < totalSteps - 1 ? 'inline-flex' : 'none';
    btnSubmit.style.display = step === totalSteps - 1 ? 'inline-flex' : 'none';
    currentStep = step;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// =============================================
//  VALIDASI PER STEP
// =============================================
function validateStep(step) {
    let valid = true;

    if (step === 0) {
        const phone   = document.getElementById('phone');
        const gender  = document.getElementById('gender');
        const address = document.getElementById('address');
        let errors    = [];

        [phone, gender, address].forEach(el => el.style.borderColor = '');

        if (!phone.value.trim()) {
            phone.style.borderColor = '#ba1a1a';
            errors.push('Nomor telepon wajib diisi.');
        }
        if (!gender.value) {
            gender.style.borderColor = '#ba1a1a';
            errors.push('Jenis kelamin wajib dipilih.');
        }
        if (!address.value.trim()) {
            address.style.borderColor = '#ba1a1a';
            errors.push('Domisili wajib diisi.');
        }

        if (errors.length > 0) {
            showStepError(errors.join(' '));
            valid = false;
        } else {
            hideStepError();
        }
    }

    if (step === 1) {
        const level       = document.querySelector('[name="education[0][level]"]');
        const institution = document.querySelector('[name="education[0][institution]"]');
        let errors        = [];

        [level, institution].forEach(el => el.style.borderColor = '');

        if (!level.value) {
            level.style.borderColor = '#ba1a1a';
            errors.push('Jenjang pendidikan wajib dipilih.');
        }
        if (!institution.value.trim()) {
            institution.style.borderColor = '#ba1a1a';
            errors.push('Nama institusi wajib diisi.');
        }

        if (errors.length > 0) {
            showStepError(errors.join(' '));
            valid = false;
        } else {
            hideStepError();
        }
    }

    return valid;
}

function validateSubmit() {
    const cvInput = document.getElementById('cv-input');
    if (!cvInput.files || cvInput.files.length === 0) {
        showStepError('CV wajib diupload sebelum mengirim lamaran.');
        return false;
    }
    hideStepError();
    return true;
}

function showStepError(msg) {
    let el = document.getElementById('step-error');
    if (!el) {
        el = document.createElement('div');
        el.id = 'step-error';
        el.style.cssText = 'background:rgba(186,26,26,0.08);border:1px solid rgba(186,26,26,0.2);border-radius:10px;padding:12px 16px;color:#ba1a1a;font-size:14px;margin-bottom:16px;';
        document.querySelector('.step-content[data-step="' + currentStep + '"]').before(el);
    }
    el.innerHTML = `<i class="bi bi-exclamation-circle me-2"></i>${msg}`;
    el.style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hideStepError() {
    const el = document.getElementById('step-error');
    if (el) el.style.display = 'none';
}

// =============================================
//  NAVIGATION
// =============================================
btnNext.addEventListener('click', () => {
    if (currentStep < totalSteps - 1) {
        if (!validateStep(currentStep)) return;
        goToStep(currentStep + 1);
    }
});

btnPrev.addEventListener('click', () => {
    if (currentStep > 0) {
        hideStepError();
        goToStep(currentStep - 1);
    }
});

btnSubmit.addEventListener('click', () => {
    if (!validateSubmit()) return;
    document.getElementById('apply-form').submit();
});

// =============================================
//  SUMMARY COUNTER
// =============================================
const summaryEl = document.querySelector('[name="summary"]');
const countEl   = document.getElementById('summary-count');
if (summaryEl && countEl) {
    summaryEl.addEventListener('input', () => {
        countEl.textContent = summaryEl.value.length + '/500';
    });
}

// =============================================
//  CV PREVIEW
// =============================================
const cvInput = document.getElementById('cv-input');
const cvName  = document.getElementById('cv-name');
if (cvInput) {
    cvInput.addEventListener('change', () => {
        if (cvInput.files[0]) {
            cvName.style.display = 'block';
            cvName.querySelector('span').textContent = cvInput.files[0].name;
            hideStepError();
        }
    });
}

// =============================================
//  DOKUMEN PENDUKUNG — KUMPULIN SEMUA FILE
// =============================================
const docsInput = document.getElementById('docs-input');
const docsList  = document.getElementById('docs-list');
let allDocs     = [];

if (docsInput) {
    docsInput.addEventListener('change', () => {
        [...docsInput.files].forEach(f => {
            if (f.size > 5 * 1024 * 1024) {
                showDocsError(`File "${f.name}" melebihi batas maksimal 5MB.`);
                return;
            }
            if (!allDocs.find(d => d.name === f.name)) {
                allDocs.push(f);
            }
        });
        renderDocsList();
        docsInput.value = '';
    });
}

function showDocsError(msg) {
    let el = document.getElementById('docs-error');
    if (!el) {
        el = document.createElement('div');
        el.id = 'docs-error';
        el.style.cssText = 'background:rgba(186,26,26,0.08);border:1px solid rgba(186,26,26,0.2);border-radius:10px;padding:12px 16px;color:#ba1a1a;font-size:13px;margin-top:8px;';
        document.getElementById('docs-list').before(el);
    }
    el.innerHTML = `<i class="bi bi-exclamation-circle me-2"></i>${msg}`;
    el.style.display = 'block';
    setTimeout(() => { el.style.display = 'none'; }, 4000);
}
function renderDocsList() {
    docsList.innerHTML = '';
    allDocs.forEach((f, idx) => {
        const div = document.createElement('div');
        div.style.cssText = 'padding:8px 12px;background:#f8faff;border-radius:8px;border:1px solid #e8edf5;font-size:13px;color:#374151;display:flex;align-items:center;justify-content:space-between;gap:8px;';
        div.innerHTML = `
            <div style="display:flex;align-items:center;gap:8px;">
                <i class="bi bi-paperclip" style="color:var(--primary-color);"></i>${f.name}
            </div>
            <button type="button" onclick="removeDoc(${idx})" style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:14px;">
                <i class="bi bi-x-lg"></i>
            </button>`;
        docsList.appendChild(div);
    });
    syncDocsToForm();
}

function removeDoc(idx) {
    allDocs.splice(idx, 1);
    renderDocsList();
}

function syncDocsToForm() {
    const hiddenContainer = document.getElementById('docs-hidden');
    hiddenContainer.innerHTML = '';

    if (allDocs.length > 0) {
        const inp = document.createElement('input');
        inp.type = 'file';
        inp.name = 'documents[]';
        inp.multiple = true;
        inp.style.display = 'none';
        inp.id = 'docs-real';
        hiddenContainer.appendChild(inp);

        const dataTransfer = new DataTransfer();
        allDocs.forEach(f => dataTransfer.items.add(f));
        inp.files = dataTransfer.files;
    }
}

// =============================================
//  BATASI TAHUN 4 DIGIT
// =============================================
document.addEventListener('input', (e) => {
    if (e.target.classList.contains('year-input')) {
        if (e.target.value.length > 4) {
            e.target.value = e.target.value.slice(0, 4);
        }
    }
});

// =============================================
//  ADD EDUCATION
// =============================================
let eduCount = 1;
document.getElementById('add-edu').addEventListener('click', () => {
    const i = eduCount++;
    const entry = document.createElement('div');
    entry.className = 'edu-entry';
    entry.style.cssText = 'background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;position:relative;';
    entry.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" style="position:absolute;top:12px;right:12px;background:none;border:none;color:#94a3b8;cursor:pointer;font-size:16px;">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="apply-label">Jenjang</label>
                <select name="education[${i}][level]" class="apply-input">
                    <option value="">Pilih</option>
                    <option value="SMA/SMK">SMA/SMK</option>
                    <option value="D3">D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="apply-label">Nama Institusi</label>
                <input type="text" name="education[${i}][institution]" class="apply-input" placeholder="Universitas / Sekolah">
            </div>
            <div class="col-md-6">
                <label class="apply-label">Jurusan</label>
                <input type="text" name="education[${i}][major]" class="apply-input" placeholder="Teknik Informatika">
            </div>
            <div class="col-md-3">
                <label class="apply-label">Tahun Masuk</label>
                <input type="number" name="education[${i}][year_start]" class="apply-input year-input" placeholder="2018" min="1900" max="2030">
            </div>
            <div class="col-md-3">
                <label class="apply-label">Tahun Lulus</label>
                <input type="number" name="education[${i}][year_end]" class="apply-input year-input" placeholder="2022" min="1900" max="2030">
            </div>
            <div class="col-md-3">
                <label class="apply-label">IPK / Nilai</label>
                <input type="text" name="education[${i}][gpa]" class="apply-input" placeholder="3.75">
            </div>
        </div>`;
    document.getElementById('edu-list').appendChild(entry);
});

// =============================================
//  ADD EXPERIENCE
// =============================================
let expCount = 1;
document.getElementById('add-exp').addEventListener('click', () => {
    const i = expCount++;
    const entry = document.createElement('div');
    entry.className = 'exp-entry';
    entry.style.cssText = 'background:#f8faff;border-radius:12px;padding:20px;border:1px solid #e8edf5;position:relative;';
    entry.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" style="position:absolute;top:12px;right:12px;background:none;border:none;color:#94a3b8;cursor:pointer;font-size:16px;">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="apply-label">Posisi / Jabatan</label>
                <input type="text" name="experience[${i}][position]" class="apply-input" placeholder="Software Engineer">
            </div>
            <div class="col-md-6">
                <label class="apply-label">Nama Perusahaan</label>
                <input type="text" name="experience[${i}][company]" class="apply-input" placeholder="PT Contoh Indonesia">
            </div>
            <div class="col-md-3">
                <label class="apply-label">Tahun Mulai</label>
                <input type="number" name="experience[${i}][year_start]" class="apply-input year-input" placeholder="2020" min="1900" max="2030">
            </div>
            <div class="col-md-3">
                <label class="apply-label">Tahun Selesai</label>
                <input type="number" name="experience[${i}][year_end]" class="apply-input year-input" placeholder="2023" min="1900" max="2030">
            </div>
            <div class="col-md-6">
                <label class="apply-label">Masih Bekerja?</label>
                <select name="experience[${i}][current]" class="apply-input">
                    <option value="0">Tidak</option>
                    <option value="1">Ya (masih aktif)</option>
                </select>
            </div>
        </div>`;
    document.getElementById('exp-list').appendChild(entry);
});

// =============================================
//  INIT
// =============================================
goToStep(0);