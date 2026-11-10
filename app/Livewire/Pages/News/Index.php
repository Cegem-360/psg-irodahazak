<?php

declare(strict_types=1);

namespace App\Livewire\Pages\News;

use App\Livewire\Concerns\RendersAsPage;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Index extends Component
{
    use RendersAsPage;

    public function render(): View
    {
        return $this->asPage(view('pages.news.index'), [['name' => __('News'), 'url' => localized_route('news.index')]]);
    }
}
