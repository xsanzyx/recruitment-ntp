<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'otp_code',
        'otp_expires_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at'    => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Helper: nama lengkap
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Helper: cek OTP masih valid
    public function isOtpValid(string $code): bool
    {
        return $this->otp_code === $code
            && $this->otp_expires_at
            && now()->lessThanOrEqualTo($this->otp_expires_at);
    }

    // =============================================
    //  ROLE HELPERS
    // =============================================

    public function isHR(): bool
    {
        return $this->role === 'hr';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKandidat(): bool
    {
        return $this->role === 'kandidat';
    }

    // =============================================
    //  RELATIONSHIPS
    // =============================================

    /** Profil kandidat (1:1) */
    public function profile(): HasOne
    {
        return $this->hasOne(CandidateProfile::class);
    }

    /** Lowongan yang dibuat oleh HR */
    public function jobVacancies(): HasMany
    {
        return $this->hasMany(JobVacancy::class, 'created_by');
    }

    /** Lamaran yang dikirim kandidat */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /** Lamaran yang direview oleh HR ini */
    public function reviewedApplications(): HasMany
    {
        return $this->hasMany(Application::class, 'reviewed_by');
    }
}