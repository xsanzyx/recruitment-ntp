<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->unsignedTinyInteger('min_age')->nullable()->after('deadline');
            $table->unsignedTinyInteger('max_age')->nullable()->after('min_age');
            $table->enum('gender_requirement', ['Laki-laki', 'Perempuan', 'Semua'])->default('Semua')->after('max_age');
            $table->enum('min_education', ['SMA/SMK', 'D3', 'S1', 'S2', 'S3'])->nullable()->after('gender_requirement');
        });
    }

    public function down(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->dropColumn(['min_age', 'max_age', 'gender_requirement', 'min_education']);
        });
    }
};
