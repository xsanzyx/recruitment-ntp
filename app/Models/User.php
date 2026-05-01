<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'status',
        'last_active_at',
        'otp_code',
        'otp_expires_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_active_at'    => 'datetime',
        'password'          => 'hashed',
    ];

    // ── Helper methods ──────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isHR(): bool
    {
        return $this->role === 'hr';
    }

    public function isKandidat(): bool
    {
        return $this->role === 'user';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    // Avatar inisial (untuk tampilan UI)
    public function getInitialAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1));
    }

    // Label role dalam Bahasa Indonesia
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Admin',
            'hr'    => 'HR',
            'user'  => 'Kandidat',
            default => ucfirst($this->role),
        };
    }

    // Label status
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active'    => 'Aktif',
            'pending'   => 'Pending',
            'nonactive' => 'Nonaktif',
            default     => ucfirst($this->status),
        };
    }

    /**
     * Cek apakah OTP valid dan belum kadaluarsa
     */
    public function isOtpValid(string $code): bool
    {
        return $this->otp_code === $code && 
               $this->otp_expires_at && 
               $this->otp_expires_at->isFuture();
    }
}
