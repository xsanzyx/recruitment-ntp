<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVacancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'department',
        'description',
        'requirements',
        'division',
        'type',
        'status',
        'deadline',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

    // =============================================
    //  RELATIONSHIPS
    // =============================================

    /** HR yang membuat lowongan ini */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Semua lamaran untuk lowongan ini */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    // =============================================
    //  SCOPES
    // =============================================

    /** Hanya lowongan yang berstatus open */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /** Hanya lowongan yang berstatus closed */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    // =============================================
    //  HELPERS
    // =============================================

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }
}
