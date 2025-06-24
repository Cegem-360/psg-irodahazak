<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\View\View;

final class TestimonialController extends Controller
{
    public function index(): View
    {
        $currentLang = app()->getLocale();

        $testimonials = Testimonial::active()
            ->forLang($currentLang)
            ->ordered()
            ->paginate(12);

        $featuredTestimonials = Testimonial::active()
            ->featured()
            ->forLang($currentLang)
            ->ordered()
            ->limit(6)
            ->get();

        return view('testimonials.index', ['testimonials' => $testimonials, 'featuredTestimonials' => $featuredTestimonials]);
    }

    public function show(Testimonial $testimonial): View
    {
        abort_unless($testimonial->is_active, 404);

        return view('testimonials.show', ['testimonial' => $testimonial]);
    }
}
