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
        'min_age',
        'max_age',
        'gender_requirement',
        'min_education',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'min_age'  => 'integer',
            'max_age'  => 'integer',
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

    /**
     * Cek apakah kandidat memenuhi syarat lowongan ini
     *
     * @param  \App\Models\CandidateProfile  $profile
     * @return array ['eligible' => bool, 'reasons' => string[]]
     */
    public function checkEligibility(CandidateProfile $profile): array
    {
        $reasons = [];
        $educationHierarchy = ['SMA/SMK' => 1, 'D3' => 2, 'S1' => 3, 'S2' => 4, 'S3' => 5];

        // Cek umur
        $age = $profile->getAge();
        if ($age !== null) {
            if ($this->min_age && $age < $this->min_age) {
                $reasons[] = "Umur minimal {$this->min_age} tahun (umur kamu: {$age} tahun)";
            }
            if ($this->max_age && $age > $this->max_age) {
                $reasons[] = "Umur maksimal {$this->max_age} tahun (umur kamu: {$age} tahun)";
            }
        }

        // Cek gender
        if ($this->gender_requirement && $this->gender_requirement !== 'Semua') {
            if ($profile->gender && $profile->gender !== $this->gender_requirement) {
                $reasons[] = "Lowongan ini khusus untuk {$this->gender_requirement}";
            }
        }

        // Cek pendidikan minimal
        if ($this->min_education) {
            $candidateLevel = $profile->getHighestEducationLevel();
            if ($candidateLevel) {
                $minRank = $educationHierarchy[$this->min_education] ?? 0;
                $candidateRank = $educationHierarchy[$candidateLevel] ?? 0;
                if ($candidateRank < $minRank) {
                    $reasons[] = "Pendidikan minimal {$this->min_education} (pendidikan kamu: {$candidateLevel})";
                }
            }
        }

        return [
            'eligible' => empty($reasons),
            'reasons'  => $reasons,
        ];
    }
}
