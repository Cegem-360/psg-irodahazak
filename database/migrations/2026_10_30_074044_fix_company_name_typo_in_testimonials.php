<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The Lavylites testimonial misspells the company as "Propety Solution Group".
     */
    public function up(): void
    {
        DB::table('testimonials')
            ->where('testimonial', 'like', '%Propety Solution%')
            ->update(['testimonial' => DB::raw("REPLACE(testimonial, 'Propety Solution', 'Property Solution')")]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
