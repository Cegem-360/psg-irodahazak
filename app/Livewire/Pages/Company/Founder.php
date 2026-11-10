<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Company;

use App\Livewire\Concerns\RendersAsPage;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * /fekete-richard: the founder and managing director, the author of the news
 * and of the rental fee overview. Hungarian only.
 */
final class Founder extends Component
{
    use RendersAsPage;

    public function mount(): void
    {
        app()->setLocale('hu');
    }

    public function render(): View
    {
        return $this->asPage(view('pages.company.founder'), [
            ['name' => __('About Us'), 'url' => route('rolunk')],
            ['name' => 'Fekete Richárd', 'url' => route('fekete-richard')],
        ]);
    }
}
