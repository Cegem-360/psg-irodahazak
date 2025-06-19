<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class LanguageSwitchTest extends TestCase
{
    public function test_language_switch_to_hungarian_from_homepage()
    {
        // Start from homepage
        $response = $this->get('/');
        $response->assertStatus(200);

        // Switch to Hungarian (should stay on homepage)
        $response = $this->get('/language/hu', [
            'HTTP_REFERER' => 'http://localhost/',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('locale', 'hu');
    }

    public function test_language_switch_to_english_from_homepage()
    {
        // Start from homepage
        $response = $this->get('/');
        $response->assertStatus(200);

        // Switch to English (should redirect to /en)
        $response = $this->get('/language/en', [
            'HTTP_REFERER' => 'http://localhost/',
        ]);

        $response->assertRedirect('/en');
        $response->assertSessionHas('locale', 'en');
    }

    public function test_language_switch_from_english_page()
    {
        // Start from English contact page
        $response = $this->get('/en/contact');
        $response->assertStatus(200);

        // Switch to Hungarian
        $response = $this->get('/language/hu', [
            'HTTP_REFERER' => 'http://localhost/en/contact',
        ]);

        $response->assertRedirect('/kapcsolat');
        $response->assertSessionHas('locale', 'hu');
    }

    public function test_language_switch_from_hungarian_page()
    {
        // Start from Hungarian contact page
        $response = $this->get('/kapcsolat');
        $response->assertStatus(200);

        // Switch to English
        $response = $this->get('/language/en', [
            'HTTP_REFERER' => 'http://localhost/kapcsolat',
        ]);

        $response->assertRedirect('/en/contact');
        $response->assertSessionHas('locale', 'en');
    }

    public function test_invalid_locale_returns_404()
    {
        $response = $this->get('/language/invalid');
        $response->assertStatus(404);
    }

    public function test_language_switch_without_referer_redirects_to_homepage()
    {
        // Switch to English without referer
        $response = $this->get('/language/en');
        $response->assertRedirect('/en');

        // Switch to Hungarian without referer
        $response = $this->get('/language/hu');
        $response->assertRedirect('/');
    }
}
