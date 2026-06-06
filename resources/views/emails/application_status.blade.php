<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Lamaran — PT Nusantara Turbin dan Propulsi</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f1f5f9;
            font-family: 'Inter', 'Segoe UI', Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .wrap {
            max-width: 560px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        }

        .header {
            background: #002870;
            padding: 40px 32px;
            text-align: center;
            position: relative;
        }

        .header .logo-sub {
            color: #f8b830;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin: 0 0 6px;
        }

        .header h1 {
            color: #ffffff;
            font-size: 20px;
            margin: 0;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .body {
            padding: 40px;
        }

        .body h2 {
            font-size: 22px;
            color: #0f172a;
            margin: 0 0 16px;
            font-weight: 700;
        }

        .body p {
            font-size: 15px;
            color: #475569;
            line-height: 1.7;
            margin: 0 0 24px;
        }

        .status-card {
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 28px;
            text-align: center;
        }

        .status-card.lolos {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .status-card.tidak_lolos {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .status-card.lolos .status-badge {
            background: #16a34a;
            color: #ffffff;
        }

        .status-card.tidak_lolos .status-badge {
            background: #dc2626;
            color: #ffffff;
        }

        .position-name {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 4px 0 0;
        }

        .notes-box {
            background: #f8fafc;
            border-left: 4px solid #002870;
            border-radius: 0 8px 8px 0;
            padding: 18px;
            font-size: 14px;
            color: #334155;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .notes-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .btn-action {
            display: inline-block;
            background: #002870;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 40, 112, 0.15);
            transition: all 0.2s ease;
        }

        .footer {
            background: #f8fafc;
            padding: 24px 40px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            line-height: 1.5;
        }

        .footer a {
            color: #002870;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="header">
            <div class="logo-sub">Careers Portal</div>
            <h1>PT Nusantara Turbin dan Propulsi</h1>
        </div>
        <div class="body">
            <h2>Halo, {{ $application->user->first_name }}!</h2>

            @if($status === 'lolos')
                <p>Terima kasih telah berpartisipasi dalam proses seleksi di PT Nusantara Turbin dan Propulsi. Kami sangat senang mengumumkan bahwa lamaran Anda telah berhasil lolos pada tahap peninjauan awal!</p>

                <div class="status-card lolos">
                    <span class="status-badge">Lolos Seleksi</span>
                    <div class="position-name">{{ $application->jobVacancy->title }}</div>
                </div>

                @if($application->review_notes)
                    <div class="notes-box">
                        <div class="notes-title">Catatan Tim Rekrutmen:</div>
                        <div>"{!! nl2br(e($application->review_notes)) !!}"</div>
                    </div>
                @endif

                <p>Tahap selanjutnya adalah proses wawancara/test teknis. Tim HR kami akan menghubungi Anda segera melalui WhatsApp atau Email untuk menjadwalkan waktu pelaksanaan.</p>
                
                <div style="text-align: center; margin: 32px 0 16px;">
                    <a href="{{ route('profile') }}" class="btn-action">Lihat Detail Lamaran</a>
                </div>
            @else
                <p>Terima kasih atas minat dan waktu yang telah Anda dedikasikan untuk melamar di PT Nusantara Turbin dan Propulsi. Setelah melalui proses peninjauan berkas yang ketat, dengan berat hati kami menginformasikan bahwa lamaran Anda belum dapat kami lanjutkan ke tahap berikutnya.</p>

                <div class="status-card tidak_lolos">
                    <span class="status-badge">Belum Lolos</span>
                    <div class="position-name">{{ $application->jobVacancy->title }}</div>
                </div>

                @if($application->review_notes)
                    <div class="notes-box">
                        <div class="notes-title">Umpan Balik (Feedback):</div>
                        <div>"{!! nl2br(e($application->review_notes)) !!}"</div>
                    </div>
                @endif

                <p>Kami sangat menghargai profil dan bakat Anda. Database Anda akan tetap tersimpan di dalam sistem kami, dan kami akan menghubungi Anda kembali jika terdapat posisi lowongan baru di masa depan yang sesuai dengan kualifikasi Anda.</p>
                
                <p>Tetap semangat dan sukses selalu untuk perjalanan karir Anda selanjutnya!</p>
            @endif
        </div>
        <div class="footer">
            © 2026 PT Nusantara Turbin dan Propulsi <br>
            Jl. Pajajaran No. 154, Bandara Husein Sastranegara, Bandung 40174 <br>
            Website: <a href="https://ntp.co.id" target="_blank">ntp.co.id</a>
        </div>
    </div>
</body>

</html>
