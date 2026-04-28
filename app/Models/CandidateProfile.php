<?php

namespace App\Models;

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
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    /** Kandidat pemilik profil */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
