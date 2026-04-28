{{-- =============================================
     resources/views/auth/verify-email.blade.php
     Usage: @include('auth.verify-email')
     Requires: JS di app.js (initOtpModal)
     ============================================= --}}

<div class="otp-backdrop" id="otp-backdrop" style="display:none;">
    <div class="otp-modal" id="otp-modal">

        {{-- FORM STATE --}}
        <div id="otp-form-state">

            <div class="otp-top">
                <div class="otp-icon">
                    <i class="bi bi-envelope-check"></i>
                </div>
                <h2 class="fw-bold mb-2">Verifikasi Email Anda</h2>
                <p class="text-muted mb-0">
                    Kami sudah mengirim kode 6 digit ke<br>
                    <strong id="otp-email-display">—</strong>
                </p>
            </div>

            <div class="otp-mid">
                <div class="otp-boxes" id="otp-boxes">
                    <input class="otp-box" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code">
                    <input class="otp-box" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input class="otp-box" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input class="otp-box" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input class="otp-box" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input class="otp-box" maxlength="1" inputmode="numeric" pattern="[0-9]">
                </div>

                {{-- Error message --}}
                <p class="otp-error" id="otp-error" style="display:none;">
                    <i class="bi bi-x-circle"></i> Kode salah. Silakan coba lagi.
                </p>

                <button class="otp-btn" id="otp-verify-btn" disabled>
                    Verifikasi &amp; Lanjutkan
                </button>
            </div>

            <div class="otp-resend-wrap">
                <p class="mb-1">Belum menerima kode?</p>
                <span class="otp-timer" id="otp-timer">Kirim ulang dalam 60s</span>
            </div>

            <div class="otp-footer">
                <p>Demi keamanan akun, jangan bagikan kode ini ke siapapun
                termasuk yang mengaku dari PT Nusantara Turbin dan Propulsi</p>
            </div>

        </div>

        {{-- SUCCESS STATE --}}
        <div id="otp-success-state" style="display:none;">
            <div class="otp-success">
                <div class="otp-success-icon">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <h2 class="fw-bold mb-2">Email Terverifikasi!</h2>
                <p class="text-muted mb-0">Akunmu sudah aktif dan siap digunakan.</p>
                <a href="{{ route('login') }}" class="btn btn-secondary-custom px-4 mt-3">
                    Masuk Sekarang
                </a>
            </div>
        </div>

    </div>
</div>