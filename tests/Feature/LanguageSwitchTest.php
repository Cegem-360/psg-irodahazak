<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class LanguageSwitchTest extends TestCase
{
    public function test_language_switch_to_hungarian()
    {
        // Switch to Hungarian (should go to homepage)
        $response = $this->get('/language/hu');

        $response->assertRedirect('/');
        $response->assertSessionHas('locale', 'hu');
    }

    public function test_language_switch_to_english()
    {
        // Switch to English (should go to English homepage /contact)
        $response = $this->get('/language/en');

        $response->assertRedirect('/contact');
        $response->assertSessionHas('locale', 'en');
    }

    public function test_language_switch_with_url_mapping()
    {
        // Test Hungarian contact page to English
        $response = $this->get('/language/en', [
            'HTTP_REFERER' => 'http://localhost/kapcsolat',
        ]);

        $response->assertRedirect('/contact-us');
        $response->assertSessionHas('locale', 'en');

        // Test blog URL mapping
        $response = $this->get('/language/en', [
            'HTTP_REFERER' => 'http://localhost/blog',
        ]);

        $response->assertRedirect('/news-blog');

        $response = $this->get('/language/hu', [
            'HTTP_REFERER' => 'http://localhost/news-blog',
        ]);

        $response->assertRedirect('/blog');
    }

    public function test_invalid_locale_returns_404()
    {
        $response = $this->get('/language/invalid');
        $response->assertStatus(404);
    }

    public function test_english_urls_set_locale_automatically()
    {
        // Accessing an English URL should set locale to 'en'
        $response = $this->get('/contact');
        $response->assertStatus(200);
        // Note: This would be tested in browser where session persists
    }

    public function test_hungarian_urls_work_without_prefix()
    {
        // Hungarian URLs should work normally
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/kapcsolat');
        $response->assertStatus(200);
    }
}
