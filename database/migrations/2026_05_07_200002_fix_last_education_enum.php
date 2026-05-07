<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum last_education agar termasuk 'SMA/SMK'
        DB::statement("ALTER TABLE candidate_profiles MODIFY COLUMN last_education ENUM('SMA/SMK','D3','S1','S2','S3') NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE candidate_profiles MODIFY COLUMN last_education ENUM('SMA','D3','S1','S2','S3') NULL");
    }
};
