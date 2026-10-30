<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Home extends Component
{
    use RendersAsPage;

    public function render(): View
    {
        return $this->asPage(view('pages.home'));
    }
}
