<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\AboutUs as AboutUsContent;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class AboutUs extends Component
{
    use RendersAsPage;

    public function render(): View
    {
        return $this->asPage(view('pages.about-us', [
            'aboutUs' => AboutUsContent::query()->active()->byLanguage(app()->getLocale())->get(),
        ]), [['name' => __('About Us'), 'url' => localized_route('rolunk')]]);
    }
}
