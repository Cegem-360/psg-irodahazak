<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\ContactPage;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Contact extends Component
{
    use RendersAsPage;

    public function render(): View
    {
        return $this->asPage(view('pages.contact', [
            'contactPage' => ContactPage::getActiveByLanguage(app()->getLocale()),
        ]), [['name' => __('contact.title'), 'url' => localized_route('kapcsolat')]]);
    }
}
