<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('last_name');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('portfolio_url')->nullable()->after('bio');
            $table->string('linkedin_url')->nullable()->after('portfolio_url');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'bio', 'portfolio_url', 'linkedin_url']);
        });
    }
};