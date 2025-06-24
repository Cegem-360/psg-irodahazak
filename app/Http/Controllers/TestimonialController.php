<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\View\View;

final class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::active()
            ->ordered()
            ->paginate(12);

        $featuredTestimonials = Testimonial::active()
            ->featured()
            ->ordered()
            ->limit(6)
            ->get();

        return view('testimonials.index', compact('testimonials', 'featuredTestimonials'));
    }

    public function show(Testimonial $testimonial): View
    {
        abort_unless($testimonial->is_active, 404);

        return view('testimonials.show', compact('testimonial'));
    }
}
