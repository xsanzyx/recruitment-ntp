<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Mengubah tipe kolom role dari ENUM menjadi VARCHAR (string) agar mendukung role 'manager'
            $table->string('role', 50)->default('kandidat')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'hr', 'manager', 'user', 'kandidat'])->default('kandidat')->change();
        });
    }
};
