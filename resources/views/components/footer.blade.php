{{-- resources/views/components/footer.blade.php --}}
<footer class="site-footer">
    <div class="container">
        <div class="row g-5">

            {{-- Brand --}}
            <div class="col-lg-4">
                <div class="footer-brand">NTP <span>Careers</span></div>
                <p class="footer-desc">
                    Platform rekrutmen resmi PT Nusantara Turbin dan Propulsi.
                    Membangun karir profesional dan berkontribusi untuk kemajuan
                    industri turbin nasional.
                </p>
                <div class="footer-social">
                    <a href="https://www.instagram.com/ntpindonesia" target="_blank" rel="noopener" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://youtube.com/@ntpindonesia2335" target="_blank" rel="noopener" title="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="mailto:info@ntp.id" title="Email">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
            </div>

            {{-- Navigasi --}}
            <div class="col-lg-4">
                <h5 class="footer-heading">Navigasi</h5>
                <a href="{{ route('home') }}"              class="footer-link">Beranda</a>
                <a href="{{ route('lowongan') }}"          class="footer-link">Lowongan</a>
                <a href="{{ route('proses-rekrutmen') }}"  class="footer-link">Proses Rekrutmen</a>
                <a href="{{ route('tentang') }}"           class="footer-link">Tentang Kami</a>
                <a href="{{ route('kontak') }}"            class="footer-link">Kontak</a>
            </div>

            {{-- Kontak --}}
            <div class="col-lg-4">
                <h5 class="footer-heading">Kontak Kami</h5>
                <div class="footer-contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <span>hr@ntp.co.id</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <span>+62 22 605 5555</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Jl. Pajajaran No. 154, Bandung 40174</span>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p>© 2026 NTP Careers — PT Nusantara Turbin dan Propulsi. All rights reserved.</p>
        </div>
    </div>
</footer>