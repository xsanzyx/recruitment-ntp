<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->json('education')->nullable()->after('summary');
            $table->json('experience')->nullable()->after('education');
            $table->string('gpa', 10)->nullable()->after('experience');
            $table->string('resume_path')->nullable()->after('gpa');
            $table->json('documents')->nullable()->after('resume_path');
        });
    }

    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn(['education', 'experience', 'gpa', 'resume_path', 'documents']);
        });
    }
};
