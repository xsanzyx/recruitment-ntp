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
        'phone',
        'birthdate',
        'gender',
        'address',
        'summary',
        'education',
        'experience',
        'cover_letter',
        'resume_path',
        'documents',
        'status',
        'reviewed_by',
        'review_notes',
        'applied_at',
    ];

    protected function casts(): array
    {
        return [
            'applied_at' => 'datetime',
            'birthdate'  => 'date',
            'education'  => 'array',
            'experience' => 'array',
            'documents'  => 'array',
        ];
    }

    // =============================================
    //  RELATIONSHIPS
    // =============================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobVacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // =============================================
    //  HELPERS
    // =============================================

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