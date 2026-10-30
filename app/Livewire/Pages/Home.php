<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\BlogPost;
use App\Models\News;
use App\Models\Property;
use App\Models\Reference;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * The home page; its sections are Blade components that get their records from here.
 */
final class Home extends Component
{
    use RendersAsPage;

    /**
     * @return Collection<int, Property>
     */
    #[Computed]
    public function featuredProperties(): Collection
    {
        return Property::query()->active()->featured()->get();
    }

    /**
     * @return Collection<int, Testimonial>
     */
    #[Computed]
    public function testimonials(): Collection
    {
        return Testimonial::query()->active()->forLang(app()->getLocale())->ordered()->get();
    }

    /**
     * @return Collection<int, Reference>
     */
    #[Computed]
    public function references(): Collection
    {
        return Reference::query()->active()->ordered()->get();
    }

    /**
     * @return Collection<int, BlogPost>
     */
    #[Computed]
    public function latestPosts(): Collection
    {
        return BlogPost::query()->published()->latest('published_at')->take(3)->get();
    }

    /**
     * @return Collection<int, News>
     */
    #[Computed]
    public function latestNews(): Collection
    {
        return News::query()->published()->latest('published_at')->take(3)->get();
    }

    public function render(): View
    {
        return $this->asPage(view('pages.home'));
    }
}
