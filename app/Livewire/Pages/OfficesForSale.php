<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class OfficesForSale extends Component
{
    use RendersAsPage;

    public function render(): View
    {
        return $this->asPage(view('pages.offices-for-sale'), [['name' => __('Office Buildings for Sale'), 'url' => localized_route('elado-irodahazak')]]);
    }
}
