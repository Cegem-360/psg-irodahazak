<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Company;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\AboutUs as AboutUsContent;
use App\Models\Reference;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * The About Us page: the approved Hungarian text with the clients' logos and
 * testimonials; the English page still shows the paragraphs edited in the admin.
 */
final class About extends Component
{
    use RendersAsPage;

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

    public function render(): View
    {
        return $this->asPage(view('pages.company.about', [
            'aboutUs' => AboutUsContent::query()->active()->byLanguage(app()->getLocale())->get(),
        ]), [['name' => __('About Us'), 'url' => localized_route('rolunk')]]);
    }
}
