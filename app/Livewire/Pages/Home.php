<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\ProvidesOfficeSearchForm;
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
    use ProvidesOfficeSearchForm;
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
     * The latest blog.hu posts, the noindex ones too: the marketing request
     * (2026-11-05) took them out of the sitemap and the blog list only, and the
     * home page cards link to blog.hu, not to the noindex pages of this site.
     *
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

    /**
     * The counters of the home page: icon component, target number, unit and the two-line label.
     *
     * @return list<array{icon: string, to: int, suffix: string, label: string}>
     */
    public function stats(): array
    {
        return [
            ['icon' => 'svg.office', 'to' => 230, 'suffix' => '', 'label' => __('office buildings').'<br>'.__('on offer')],
            ['icon' => 'svg.experience', 'to' => 16, 'suffix' => ' '.__('years'), 'label' => __('of office market').'<br>'.__('experience')],
            ['icon' => 'svg.handshake', 'to' => 250, 'suffix' => '+', 'label' => __('signed').'<br>'.__('contracts')],
            ['icon' => 'svg.market', 'to' => 100, 'suffix' => ' '.__('thousand').' m²+', 'label' => __('leased').'<br>'.__('Class A office space')],
            ['icon' => 'svg.clock', 'to' => 24, 'suffix' => ' '.__('hours'), 'label' => __('within which').'<br>'.__('we send an offer')],
        ];
    }

    public function render(): View
    {
        return $this->asPage(view('pages.home'));
    }
}
