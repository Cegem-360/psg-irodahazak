<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class LanguageSwitchTest extends TestCase
{
    use RefreshDatabase;

    public function test_language_switch_to_hungarian(): void
    {
        // Switching stores the locale and redirects back; with no referer that is the homepage.
        $response = $this->get('/language/hu');

        $response->assertRedirect('/');
        $response->assertSessionHas('locale', 'hu');
    }

    public function test_language_switch_to_english(): void
    {
        // With no referer the switch redirects back to the homepage and stores the locale.
        $response = $this->get('/language/en');

        $response->assertRedirect('/');
        $response->assertSessionHas('locale', 'en');
    }

    public function test_language_switch_redirects_back_to_previous_page(): void
    {
        // The switcher returns the visitor to the page they came from (Referer).
        $response = $this->get('/language/en', [
            'HTTP_REFERER' => 'http://localhost/kapcsolat',
        ]);

        $response->assertRedirect('http://localhost/kapcsolat');
        $response->assertSessionHas('locale', 'en');

        $response = $this->get('/language/hu', [
            'HTTP_REFERER' => 'http://localhost/news-blog',
        ]);

        $response->assertRedirect('http://localhost/news-blog');
        $response->assertSessionHas('locale', 'hu');
    }

    public function test_unknown_locale_still_redirects_back(): void
    {
        // The route does not constrain the locale, so an unknown value simply redirects back.
        $response = $this->get('/language/invalid', [
            'HTTP_REFERER' => 'http://localhost/',
        ]);

        $response->assertRedirect('http://localhost/');
        $response->assertSessionHas('locale', 'invalid');
    }

    public function test_english_contact_url_works(): void
    {
        // The English contact page lives at /contact-us and must render successfully.
        $response = $this->get('/contact-us');

        $response->assertStatus(200);
    }

    public function test_hungarian_urls_work_without_prefix(): void
    {
        // Hungarian URLs should work normally.
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/kapcsolat');
        $response->assertStatus(200);
    }
}
