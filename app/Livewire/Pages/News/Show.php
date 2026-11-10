<?php

declare(strict_types=1);

namespace App\Livewire\Pages\News;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Show extends Component
{
    use RendersAsPage;

    public News $news;

    public function mount(): void
    {
        abort_unless($this->news->is_published, 404);

        $this->news->incrementViews();
    }

    public function render(): View
    {
        return $this->asPage(view('pages.news.show'), [
            ['name' => __('News'), 'url' => localized_route('news.index')],
            ['name' => $this->news->title, 'url' => localized_route('news.show', ['news' => $this->news->slug])],
        ]);
    }
}
