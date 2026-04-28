<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_vacancy_id',
        'cover_letter',
        'resume_path',
        'status',
        'reviewed_by',
        'review_notes',
        'applied_at',
    ];

    protected function casts(): array
    {
        return [
            'applied_at' => 'datetime',
        ];
    }

    // =============================================
    //  RELATIONSHIPS
    // =============================================

    /** Kandidat yang melamar */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Lowongan yang dilamar */
    public function jobVacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class);
    }

    /** HR yang mereview lamaran ini */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // =============================================
    //  HELPERS
    // =============================================

    /** Label warna status untuk badge UI */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'warning',
            'review'      => 'info',
            'lolos'       => 'success',
            'tidak_lolos' => 'danger',
            default       => 'secondary',
        };
    }

    /** Label teks status yang ramah dibaca */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'Pending',
            'review'      => 'Sedang Direview',
            'lolos'       => 'Lolos',
            'tidak_lolos' => 'Tidak Lolos',
            default       => $this->status,
        };
    }
}
