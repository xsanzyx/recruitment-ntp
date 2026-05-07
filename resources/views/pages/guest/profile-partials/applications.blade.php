{{-- ═══ LAMARAN SAYA ═══ --}}
<div class="fade-up mb-4" style="background:#fff;border-radius:16px;padding:32px;border:1px solid #e8edf5;box-shadow:0 4px 20px rgba(0,40,112,0.06);">
    <h5 style="font-weight:700;color:var(--primary-color);margin-bottom:20px;">Lamaran Saya</h5>

    @forelse($applications as $app)
    <div style="padding:16px;border-radius:12px;border:1px solid #e8edf5;margin-bottom:12px;background:{{ !$app->is_read ? 'rgba(0,40,112,0.03)' : '#fafbff' }};">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <strong style="font-size:15px;color:var(--primary-color);">
                    {{ $app->jobVacancy->title ?? 'Lowongan tidak tersedia' }}
                </strong>
                <div style="font-size:12px;color:#94a3b8;margin-top:4px;">
                    Dikirim {{ $app->applied_at->format('d M Y') }}
                </div>
                @if($app->review_notes)
                <div style="font-size:13px;color:#64748b;margin-top:8px;padding:10px 12px;background:#f8faff;border-radius:8px;border-left:3px solid var(--primary-color);">
                    <i class="bi bi-chat-left-text me-2" style="color:var(--primary-color);"></i>
                    {{ $app->review_notes }}
                </div>
                @endif
            </div>
            <div style="flex-shrink:0;">
                @php
                    $badge = match($app->status) {
                        'pending'     => ['bg' => 'rgba(248,184,48,0.15)',  'color' => '#92620a', 'label' => 'Pending',          'icon' => 'bi-clock'],
                        'review'      => ['bg' => 'rgba(59,130,246,0.12)',  'color' => '#1d4ed8', 'label' => 'Sedang Direview',  'icon' => 'bi-search'],
                        'lolos'       => ['bg' => 'rgba(34,197,94,0.12)',   'color' => '#15803d', 'label' => 'Lolos',            'icon' => 'bi-check-circle'],
                        'tidak_lolos' => ['bg' => 'rgba(239,68,68,0.12)',   'color' => '#b91c1c', 'label' => 'Tidak Lolos',      'icon' => 'bi-x-circle'],
                        default       => ['bg' => '#f1f5f9',                'color' => '#64748b', 'label' => $app->status,       'icon' => 'bi-circle'],
                    };
                @endphp
                <span style="display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:50px;background:{{ $badge['bg'] }};color:{{ $badge['color'] }};font-size:12px;font-weight:600;white-space:nowrap;">
                    <i class="bi {{ $badge['icon'] }}"></i>{{ $badge['label'] }}
                </span>
                @if(!$app->is_read)
                <div style="font-size:11px;color:var(--primary-color);text-align:center;margin-top:6px;font-weight:600;">● Baru</div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-4">
        <i class="bi bi-file-earmark-x" style="font-size:36px;color:#cbd5e1;"></i>
        <p style="font-size:14px;color:#94a3b8;margin-top:8px;">Kamu belum melamar lowongan apapun.</p>
        <a href="{{ route('lowongan') }}" class="btn btn-secondary-custom px-4 py-2 mt-2" style="border-radius:10px;font-size:13px;">Lihat Lowongan →</a>
    </div>
    @endforelse
</div>
