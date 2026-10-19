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
}
