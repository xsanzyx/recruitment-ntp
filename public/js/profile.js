// =============================================
//  PROFILE PAGE
// =============================================

let cropper = null;

function initAvatarInput() {
    const input = document.getElementById('avatar-input');
    if (!input) return;

    input.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2MB.');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            const modal     = document.getElementById('crop-modal');
            const cropImage = document.getElementById('crop-image');

            cropImage.src = e.target.result;
            modal.style.display = 'flex';
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            cropper = new Cropper(cropImage, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                restore: false,
                guides: false,
                center: false,
                highlight: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                toggleDragModeOnDblclick: false,
            });
        };
        reader.readAsDataURL(file);
        this.value = '';
    });
}

// =============================================
//  KONFIRMASI CROP
// =============================================
document.getElementById('crop-confirm').addEventListener('click', () => {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
    const base64 = canvas.toDataURL('image/jpeg', 0.9);

    document.getElementById('avatar-preview').innerHTML =
        `<img src="${base64}" style="width:100%;height:100%;object-fit:cover;display:block;">`;

    document.getElementById('avatar-cropped').value = base64;

    const label = document.getElementById('avatar-label');
    if (label) {
        label.innerHTML = `<i class="bi bi-upload me-2"></i>Ganti Foto<input type="file" name="avatar" id="avatar-input" accept=".jpg,.jpeg,.png" style="display:none;">`;
        initAvatarInput();
    }

    closeCropModal();
});

// =============================================
//  BATAL CROP
// =============================================
document.getElementById('crop-cancel').addEventListener('click', closeCropModal);

function closeCropModal() {
    const modal = document.getElementById('crop-modal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
}

initAvatarInput();

// =============================================
//  BIO COUNTER
// =============================================
const bioEl    = document.querySelector('[name="bio"]');
const bioCount = document.getElementById('bio-count');
if (bioEl && bioCount) {
    bioEl.addEventListener('input', () => {
        bioCount.textContent = bioEl.value.length + '/500';
    });
}