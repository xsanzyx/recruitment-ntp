{{-- ═══ CV & DOKUMEN PENDUKUNG ═══ --}}
<div class="fade-up mb-4" style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
    <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:24px;">CV & Dokumen</h5>

    {{-- CV / Resume --}}
    <div class="mb-4">
        <label class="apply-label">CV / Resume * <span style="font-size:11px;color:#64748b;">(PDF, maks 5MB)</span></label>

        @if($profile->resume_path)
        <div style="padding:12px 16px;background:#f0fdf4;border-radius:10px;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:between;gap:12px;margin-bottom:10px;">
            <div style="flex:1;">
                <i class="bi bi-file-earmark-pdf me-2" style="color:#166534;"></i>
                <span style="font-size:13px;color:#166534;font-weight:600;">CV telah diupload</span>
                <a href="{{ Storage::url($profile->resume_path) }}" target="_blank" style="font-size:12px;color:#15803d;margin-left:8px;">Lihat</a>
            </div>
            <button type="button" onclick="deleteResume()" style="background:none;border:none;color:#ef4444;font-size:14px;cursor:pointer;"><i class="bi bi-trash"></i></button>
        </div>
        <small class="text-muted" style="font-size:11px;">Upload file baru untuk mengganti CV yang sudah ada.</small>
        @endif

        <div class="upload-area mt-2" id="cv-area" style="position:relative;">
            <i class="bi bi-file-earmark-pdf" style="font-size:32px;color:var(--primary-color);margin-bottom:8px;display:block;"></i>
            <p style="margin:0;font-size:14px;font-weight:600;color:var(--primary-color);">{{ $profile->resume_path ? 'Ganti CV' : 'Klik atau drag & drop CV kamu' }}</p>
            <p style="margin:4px 0 0;font-size:12px;color:#64748b;">Format PDF, maksimal 5MB</p>
            <input type="file" id="cv-input" name="resume" accept=".pdf" style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;">
        </div>
        <div id="cv-name" style="display:none;margin-top:8px;padding:10px 14px;background:#f0fdf4;border-radius:8px;border:1px solid #bbf7d0;font-size:13px;color:#166534;">
            <i class="bi bi-check-circle me-2"></i><span></span>
        </div>
    </div>

    {{-- Dokumen Pendukung --}}
    <div>
        <label class="apply-label">Dokumen Pendukung <span style="font-size:11px;color:#64748b;">(sertifikat, portofolio — PDF/JPG, maks 5MB/file)</span></label>

        @if(!empty($profile->documents))
        <div class="d-flex flex-column gap-2 mb-3">
            @foreach($profile->documents as $idx => $doc)
            <div style="padding:10px 14px;background:#f8faff;border-radius:8px;border:1px solid #e8edf5;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <i class="bi bi-paperclip me-2" style="color:var(--primary-color);"></i>
                    <span style="font-size:13px;color:#334155;">{{ $doc['name'] }}</span>
                    <a href="{{ Storage::url($doc['path']) }}" target="_blank" style="font-size:12px;color:var(--primary-color);margin-left:8px;">Lihat</a>
                </div>
                <button type="button" onclick="deleteDocument({{ $idx }})" style="background:none;border:none;color:#ef4444;font-size:14px;cursor:pointer;"><i class="bi bi-trash"></i></button>
            </div>
            @endforeach
        </div>
        @endif

        <div class="upload-area" id="docs-area" style="position:relative;">
            <i class="bi bi-paperclip" style="font-size:28px;color:#94a3b8;margin-bottom:8px;display:block;"></i>
            <p style="margin:0;font-size:14px;font-weight:600;color:#64748b;">Tambah dokumen pendukung</p>
            <p style="margin:4px 0 0;font-size:12px;color:#94a3b8;">Bisa pilih beberapa file sekaligus</p>
            <input type="file" id="docs-input" name="documents[]" accept=".pdf,.jpg,.jpeg,.png" multiple style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;">
        </div>
        <div id="docs-list" class="d-flex flex-column gap-2 mt-2"></div>
    </div>
</div>

{{-- Hidden forms for delete actions (di luar main form) --}}
<template id="delete-resume-form">
    <form action="{{ route('profile.deleteResume') }}" method="POST">@csrf @method('DELETE')</form>
</template>
<template id="delete-document-form">
    <form action="{{ route('profile.deleteDocument') }}" method="POST">@csrf @method('DELETE') <input type="hidden" name="index" value=""></form>
</template>

<script>
function deleteResume() {
    if (!confirm('Yakin hapus CV?')) return;
    const tpl = document.getElementById('delete-resume-form');
    const form = tpl.content.cloneNode(true).querySelector('form');
    document.body.appendChild(form);
    form.submit();
}
function deleteDocument(idx) {
    if (!confirm('Hapus dokumen ini?')) return;
    const tpl = document.getElementById('delete-document-form');
    const form = tpl.content.cloneNode(true).querySelector('form');
    form.querySelector('input[name="index"]').value = idx;
    document.body.appendChild(form);
    form.submit();
}
</script>
