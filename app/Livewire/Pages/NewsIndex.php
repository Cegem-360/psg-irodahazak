<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class NewsIndex extends Component
{
    use RendersAsPage;

    public function render(): View
    {
        return $this->asPage(view('news.index'), [['name' => __('News'), 'url' => localized_route('news.index')]]);
    }
}
