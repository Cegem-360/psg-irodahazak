<?php

declare(strict_types=1);

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
        Schema::table('impressum', function (Blueprint $table) {
            $table->string('language', 2)->default('hu')->after('id');
            $table->index(['language', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('impressum', function (Blueprint $table) {
            $table->dropIndex(['language', 'is_active']);
            $table->dropColumn('language');
        });
    }
};
