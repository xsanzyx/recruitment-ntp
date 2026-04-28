// =============================================
//  PAGE LOADER — ganti bagian ini di app.js
//  Cari: setTimeout(() => { loader.classList.add('hide'); ... })
//  Ganti dengan blok di bawah ini
// =============================================

(function () {
    const loader = document.getElementById('page-loader');
    const fill   = document.getElementById('ld-bar-fill');
    const label  = document.getElementById('ld-bar-label');
    if (!loader) return;

    // Progress bar steps — selesai di ~1200ms
    const steps = [
        { w: 30,  delay: 0,    dur: 300, msg: 'Menginisialisasi...' },
        { w: 65,  delay: 350,  dur: 400, msg: 'Memuat aset...' },
        { w: 90,  delay: 800,  dur: 300, msg: 'Menyiapkan halaman...' },
        { w: 100, delay: 1100, dur: 200, msg: 'Selesai!' },
    ];

    steps.forEach(s => {
        setTimeout(() => {
            if (fill)  { fill.style.transition = `width ${s.dur}ms ease`; fill.style.width = s.w + '%'; }
            if (label) label.textContent = s.msg;
        }, s.delay);
    });

    // Trigger exit zoom setelah 1.35s
    // exit animation = 0.8s → total selesai di ~2.15s
    // page-enter delay = 1.6s — overlap sedikit biar smooth
    setTimeout(() => {
        loader.classList.add('hide');
        loader.addEventListener('animationend', () => {
            loader.style.display = 'none';
        }, { once: true });
    }, 1350);
})();

// ================= PAGE TRANSITION =================
document.addEventListener('DOMContentLoaded', () => {
    const transition = document.getElementById('page-transition');

    // Intercept all internal links
    document.querySelectorAll('a[href]').forEach(link => {
        const href = link.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('http') || href.startsWith('mailto')) return;

        link.addEventListener('click', function (e) {
            e.preventDefault();
            const target = this.href;

            if (transition) {
                transition.classList.add('slide-in');
                setTimeout(() => { window.location.href = target; }, 1100);
            } else {
                window.location.href = target;
            }
        });
    });
});


// ================= DOM READY =================
document.addEventListener('DOMContentLoaded', () => {

    // --- Reset sidebar state ---
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggle  = document.querySelector('.toggle-btn');

    if (sidebar) sidebar.classList.remove('active');
    if (overlay) overlay.classList.remove('active');
    if (toggle)  toggle.classList.remove('hide');


    // --- Job detail accordion ---
    document.querySelectorAll('.job-header').forEach(header => {
        header.addEventListener('click', function () {
            const card   = this.closest('.job-card');
            const detail = card.querySelector('.job-detail');
            const icon   = this.querySelector('.toggle-text i');
            if (!detail) return;

            const isOpen = detail.classList.toggle('show');
            card.classList.toggle('expanded', isOpen);
            if (icon) {
                icon.className = isOpen ? 'bi bi-chevron-up' : 'bi bi-chevron-down';
                icon.closest('.toggle-text').style.color = isOpen ? 'var(--primary-color)' : 'var(--outline)';
            }
        });
    });


    // --- Scroll animation (IntersectionObserver) ---
    const fadeEls = document.querySelectorAll('.fade-up');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        fadeEls.forEach(el => observer.observe(el));
    } else {
        fadeEls.forEach(el => el.classList.add('show'));
    }

});


// ================= SIDEBAR =================
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggle  = document.querySelector('.toggle-btn');
    if (!sidebar || !overlay || !toggle) return;

    const isActive = sidebar.classList.toggle('active');
    overlay.classList.toggle('active', isActive);
    toggle.classList.toggle('hide', isActive);
}
// =============================================
//  OTP MODAL — update di bagian bawah app.js
//  Ganti fungsi initOtpModal yang sebelumnya
// =============================================

function initOtpModal(maskedEmail) {
    const backdrop = document.getElementById('otp-backdrop');
    const boxes    = document.querySelectorAll('.otp-box');
    const btn      = document.getElementById('otp-verify-btn');
    const timerEl  = document.getElementById('otp-timer');
    const errorEl  = document.getElementById('otp-error');
    const emailEl  = document.getElementById('otp-email-display');

    if (!backdrop) return;

    if (emailEl && maskedEmail) emailEl.textContent = maskedEmail;
    backdrop.style.display = 'flex';
    boxes[0].focus();

    // ===== TIMER =====
    let countdown = 60;
    let timerInterval;

    function startTimer() {
        countdown = 60;
        timerEl.className = 'otp-timer';
        timerEl.textContent = 'Kirim ulang dalam 60s';
        timerEl.onclick = null;
        clearInterval(timerInterval);

        timerInterval = setInterval(() => {
            countdown--;
            if (countdown > 0) {
                timerEl.textContent = 'Kirim ulang dalam ' + countdown + 's';
            } else {
                clearInterval(timerInterval);
                timerEl.textContent = 'Kirim ulang sekarang';
                timerEl.className = 'otp-timer clickable';
                timerEl.onclick = () => {
                    fetch('/auth/resend-otp', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
                    }).then(() => {
                        boxes.forEach(b => { b.value = ''; b.classList.remove('filled', 'error'); });
                        if (errorEl) errorEl.style.display = 'none';
                        boxes[0].focus();
                        checkFilled();
                        startTimer();
                    });
                };
            }
        }, 1000);
    }

    // ===== CEK BOX =====
    function checkFilled() {
        const all = [...boxes].every(b => b.value !== '');
        btn.disabled = !all;
        btn.className = all ? 'otp-btn ready' : 'otp-btn';
    }

    // ===== INPUT =====
    boxes.forEach((box, i) => {
        box.addEventListener('input', () => {
            box.value = box.value.replace(/[^0-9]/g, '').slice(-1);
            box.classList.toggle('filled', box.value !== '');
            box.classList.remove('error');
            if (errorEl) errorEl.style.display = 'none';
            if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
            checkFilled();
        });

        box.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !box.value && i > 0) {
                boxes[i - 1].value = '';
                boxes[i - 1].classList.remove('filled');
                boxes[i - 1].focus();
                checkFilled();
            }
        });

        box.addEventListener('paste', e => {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData)
                .getData('text').replace(/\D/g, '').slice(0, 6);
            paste.split('').forEach((ch, j) => {
                if (boxes[j]) { boxes[j].value = ch; boxes[j].classList.add('filled'); }
            });
            boxes[Math.min(paste.length, boxes.length - 1)].focus();
            checkFilled();
        });
    });

    // ===== VERIFY =====
    btn.addEventListener('click', () => {
        if (btn.disabled) return;

        const code = [...boxes].map(b => b.value).join('');
        btn.textContent = 'Memverifikasi...';
        btn.disabled = true;

        fetch('/auth/verify-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ code })
        })
        .then(r => {
            if (!r.ok && r.status !== 422) throw new Error('Server error');
            return r.json();
        })
        .then(data => {
            if (data.success) {
                clearInterval(timerInterval);
                document.getElementById('otp-form-state').style.display    = 'none';
                document.getElementById('otp-success-state').style.display = 'block';
                // Redirect ke dashboard setelah 1.5 detik
                setTimeout(() => { window.location.href = data.redirect; }, 1500);
            } else {
                boxes.forEach(b => b.classList.add('error'));
                if (errorEl) {
                    errorEl.textContent = data.message || 'Kode salah. Silakan coba lagi.';
                    errorEl.style.display = 'block';
                }
                btn.textContent = 'Verifikasi & Lanjutkan';
                btn.disabled = false;
                btn.className = 'otp-btn ready';
            }
        })
        .catch(() => {
            if (errorEl) { errorEl.textContent = 'Terjadi kesalahan jaringan. Coba lagi.'; errorEl.style.display = 'block'; }
            btn.textContent = 'Verifikasi & Lanjutkan';
            btn.disabled = false;
            btn.className = 'otp-btn ready';
        });
    });

    startTimer();
}

// =============================================
//  AUTO-TRIGGER modal jika Laravel redirect back
//  dengan session 'show_otp'
// =============================================
document.addEventListener('DOMContentLoaded', () => {
    const otpTrigger = document.getElementById('otp-auto-trigger');
    if (otpTrigger) {
        initOtpModal(otpTrigger.dataset.email);
    }
});