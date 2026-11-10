<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Legal;

use App\Livewire\Concerns\RendersAsPage;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class PrivacyPolicy extends Component
{
    use RendersAsPage;

    public function render(): View
    {
        return $this->asPage(view('pages.legal.privacy-policy'), [['name' => __('Privacy Policy'), 'url' => localized_route('privacy-policy')]]);
    }
}
