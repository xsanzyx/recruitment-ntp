<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi</title>
    <style>
        body { margin: 0; padding: 0; background: #f1f5f9; font-family: 'Lato', Arial, sans-serif; }
        .wrap { max-width: 520px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .header { background: #002870; padding: 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 18px; margin: 8px 0 0; font-weight: 700; }
        .header p { color: rgba(255,255,255,0.5); font-size: 11px; letter-spacing: 2px; text-transform: uppercase; margin: 0; }
        .body { padding: 36px 40px; }
        .body h2 { font-size: 20px; color: #111827; margin: 0 0 8px; }
        .body p { font-size: 14px; color: #6b7280; line-height: 1.7; margin: 0 0 24px; }
        .otp-box { background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; text-align: center; padding: 24px; margin-bottom: 24px; }
        .otp-box .code { font-size: 40px; font-weight: 800; letter-spacing: 12px; color: #002870; }
        .otp-box small { font-size: 12px; color: #9ca3af; display: block; margin-top: 6px; }
        .warning { background: #fff7ed; border-left: 3px solid #f97316; border-radius: 8px; padding: 14px 16px; font-size: 13px; color: #92400e; line-height: 1.6; }
        .footer { background: #f8fafc; padding: 20px 40px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f1f5f9; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="header">
            <p>Careers Portal</p>
            <h1>PT Nusantara Turbin dan Propulsi</h1>
        </div>
        <div class="body">
            <h2>Halo, {{ $user->first_name }}!</h2>
            <p>Gunakan kode di bawah ini untuk memverifikasi alamat email kamu. Kode berlaku selama <strong>10 menit</strong>.</p>

            <div class="otp-box">
                <div class="code">{{ $otp }}</div>
                <small>Kode verifikasi 6 digit</small>
            </div>

            <div class="warning">
                ⚠️ Jangan bagikan kode ini ke siapapun, termasuk yang mengaku dari PT Nusantara Turbin dan Propulsi. Tim kami tidak pernah meminta kode verifikasi.
            </div>
        </div>
        <div class="footer">
            © 2026 PT Nusantara Turbin dan Propulsi &nbsp;·&nbsp; Jl. Pajajaran 154, Bandung
        </div>
    </div>
</body>
</html>