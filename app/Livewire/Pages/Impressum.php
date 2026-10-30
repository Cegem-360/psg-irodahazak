<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\Impresszum;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Impressum extends Component
{
    use RendersAsPage;

    public function render(): View
    {
        return $this->asPage(view('pages.impressum', [
            'impresszum' => Impresszum::query()->active()->byLanguage(app()->getLocale())->first(),
        ]), [['name' => __('Imprint'), 'url' => localized_route('impressum')]]);
    }
}
