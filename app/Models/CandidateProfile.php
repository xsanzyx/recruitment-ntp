<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'last_education',
        'phone',
        'address',
        'birth_date',
        'gender',
        'summary',
        'education',
        'experience',
        'gpa',
        'resume_path',
        'documents',
    ];

    protected function casts(): array
    {
        return [
            'birth_date'  => 'date',
            'education'   => 'array',
            'experience'  => 'array',
            'documents'   => 'array',
        ];
    }

    /** Kandidat pemilik profil */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =============================================
    //  HELPERS
    // =============================================

    /**
     * Hitung umur berdasarkan tanggal lahir
     */
    public function getAge(): ?int
    {
        if (!$this->birth_date) {
            return null;
        }
        return $this->birth_date->age;
    }

    /**
     * Ambil jenjang pendidikan tertinggi dari array education
     */
    public function getHighestEducationLevel(): ?string
    {
        if (empty($this->education)) {
            return $this->last_education;
        }

        $hierarchy = ['SMA/SMK' => 1, 'D3' => 2, 'S1' => 3, 'S2' => 4, 'S3' => 5];
        $highest = null;
        $highestRank = 0;

        foreach ($this->education as $edu) {
            $level = $edu['level'] ?? null;
            $rank = $hierarchy[$level] ?? 0;
            if ($rank > $highestRank) {
                $highestRank = $rank;
                $highest = $level;
            }
        }

        return $highest ?? $this->last_education;
    }

    /**
     * Cek apakah profil sudah lengkap (semua mandatory field terisi)
     */
    public function isProfileComplete(): bool
    {
        return !empty($this->phone)
            && !empty($this->birth_date)
            && !empty($this->gender)
            && !empty($this->address)
            && !empty($this->education)
            && $this->hasEducationGpa()
            && !empty($this->resume_path);
    }

    /**
     * Cek apakah ada entry pendidikan yang punya IPK/Nilai Akhir
     */
    public function hasEducationGpa(): bool
    {
        if (empty($this->education)) return false;

        foreach ($this->education as $edu) {
            if (!empty($edu['gpa'])) return true;
        }
        return false;
    }

    /**
     * Daftar field yang belum terisi
     */
    public function getMissingFields(): array
    {
        $missing = [];

        if (empty($this->phone))      $missing[] = 'No. Telepon';
        if (empty($this->birth_date))  $missing[] = 'Tanggal Lahir';
        if (empty($this->gender))      $missing[] = 'Jenis Kelamin';
        if (empty($this->address))     $missing[] = 'Domisili';
        if (empty($this->education))   $missing[] = 'Riwayat Pendidikan';
        if (!$this->hasEducationGpa()) $missing[] = 'IPK / Nilai Akhir (di riwayat pendidikan)';
        if (empty($this->resume_path)) $missing[] = 'CV / Resume';

        return $missing;
    }
}
