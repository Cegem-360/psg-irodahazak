<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
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

        return view('testimonials.index', ['testimonials' => $testimonials, 'featuredTestimonials' => $featuredTestimonials]);
    }

    public function show(Testimonial $testimonial): View
    {
        abort_unless($testimonial->is_active, 404);
        
        return view('testimonials.show', ['testimonial' => $testimonial]);
    }
}
