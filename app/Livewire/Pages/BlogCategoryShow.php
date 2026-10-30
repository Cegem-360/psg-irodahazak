<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

final class BlogCategoryShow extends Component
{
    use RendersAsPage;
    use WithPagination;

    public BlogCategory $category;

    public function mount(): void
    {
        abort_unless($this->category->is_active, 404);
    }

    public function render(): View
    {
        return $this->asPage(view('blog.category', [
            'posts' => BlogPost::query()->published()
                ->where('blog_category_id', $this->category->id)
                ->latest('published_at')
                ->paginate(12),
        ]), [
            ['name' => 'Blog', 'url' => route('en.blog.index')],
            ['name' => $this->category->name, 'url' => route('en.blog.category', ['category' => $this->category->slug])],
        ]);
    }
}
