<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('cover_letter');
            $table->date('birthdate')->nullable()->after('phone');
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable()->after('birthdate');
            $table->string('address')->nullable()->after('gender');
            $table->text('summary')->nullable()->after('address');
            $table->json('education')->nullable()->after('summary');
            $table->json('experience')->nullable()->after('education');
            $table->json('documents')->nullable()->after('experience');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['phone','birthdate','gender','address','summary','education','experience','documents']);
        });
    }
};