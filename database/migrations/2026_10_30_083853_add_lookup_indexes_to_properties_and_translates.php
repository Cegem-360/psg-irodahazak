<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique()->change();
            $table->index(['status', 'elado_v_kiado']);
            $table->index('featured');
        });

        // A fresh install already indexes the name; the imported production table does not.
        if (! Schema::hasIndex('translates', ['name'])) {
            Schema::table('translates', function (Blueprint $table): void {
                $table->index('name');
            });
        }
    }

    public function down(): void
    {
        Schema::table('translates', function (Blueprint $table): void {
            $table->dropIndex(['name']);
        });

        Schema::table('properties', function (Blueprint $table): void {
            $table->dropIndex(['featured']);
            $table->dropIndex(['status', 'elado_v_kiado']);
            $table->dropUnique(['slug']);
            $table->text('slug')->nullable()->change();
        });
    }
};
