<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class BlogPostShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_post_page_renders(): void
    {
        // The JSON-LD "@context" key must stay literal, not compile as Blade's @context directive.
        $post = BlogPost::factory()->published()->create();

        $response = $this->get(route('en.blog.show', $post->slug));

        $response->assertOk();
        $response->assertSee($post->title);
    }

    public function test_post_page_links_to_category_and_related_posts_in_hungarian_session(): void
    {
        // The blog only has en.* routes, so its links must not depend on the session locale.
        $post = BlogPost::factory()->published()->create();
        $relatedPost = BlogPost::factory()->published()->create(['blog_category_id' => $post->blog_category_id]);

        $response = $this->withSession(['locale' => 'hu'])->get(route('en.blog.show', $post->slug));

        $response->assertOk();
        $response->assertSee(route('en.blog.category', $post->category->slug), false);
        $response->assertSee(route('en.blog.show', $relatedPost->slug), false);
    }

    public function test_post_without_author_and_category_renders_with_brand_as_author(): void
    {
        // Imported posts in production have neither an author nor a category.
        $post = BlogPost::factory()->published()->create(['user_id' => null, 'blog_category_id' => null]);

        $response = $this->get(route('en.blog.show', $post->slug));

        $response->assertOk();
        $response->assertSee('PSG-IRODAHÁZAK');
        $response->assertDontSee('Kategória:');
    }

    public function test_post_page_head_contains_its_own_meta_tags_once(): void
    {
        // The page's "meta" slot replaces the layout defaults instead of being dropped or duplicated.
        $post = BlogPost::factory()->published()->create(['excerpt' => 'Egyedi cikk-kivonat a meta leírásba.']);

        $response = $this->get(route('en.blog.show', $post->slug));

        $response->assertOk();
        $response->assertSee('<meta name="description" content="Egyedi cikk-kivonat a meta leírásba.">', false);
        $response->assertSee('<meta property="og:type" content="article">', false);
        $response->assertSee('"@context": "https://schema.org"', false);
        $this->assertSame(1, mb_substr_count($response->getContent(), '<meta name="description"'));
        $this->assertSame(1, mb_substr_count($response->getContent(), 'property="og:type"'));
    }
}
