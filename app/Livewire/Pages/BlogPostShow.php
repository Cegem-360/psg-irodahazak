<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class BlogPostShow extends Component
{
    use RendersAsPage;

    public BlogPost $post;

    public function mount(): void
    {
        abort_unless($this->post->isPublished(), 404);

        $this->post->incrementViews();
    }

    /**
     * The latest other posts of the same category.
     *
     * @return Collection<int, BlogPost>
     */
    #[Computed]
    public function relatedPosts(): Collection
    {
        return BlogPost::query()->published()
            ->where('blog_category_id', $this->post->blog_category_id)
            ->whereKeyNot($this->post->id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(3)
            ->get();
    }

    public function render(): View
    {
        return $this->asPage(view('blog.show', ['relatedPosts' => $this->relatedPosts]), [
            ['name' => 'Blog', 'url' => route('en.blog.index')],
            ['name' => $this->post->title, 'url' => route('en.blog.show', ['post' => $this->post->slug])],
        ]);
    }
}
