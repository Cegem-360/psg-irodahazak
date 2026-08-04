<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Both columns were added to create_testimonials_table after it had already run
     * in production, so the production table lacks them while a fresh build has
     * them. Testimonial::$fillable and testimonials/show.blade.php both use them.
     */
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table): void {
            if (! Schema::hasColumn('testimonials', 'company_logo')) {
                $table->string('company_logo')->nullable()->after('client_image');
            }

            if (! Schema::hasColumn('testimonials', 'rating')) {
                $table->tinyInteger('rating')->default(5)->after('company_logo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
