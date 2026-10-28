<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\QuoteRequestModal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Symfony\Component\Mailer\SentMessage;
use Tests\TestCase;

final class QuoteRequestModalNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_submission_mails_the_visitor_and_tells_them_on_screen(): void
    {
        Livewire::test(QuoteRequestModal::class)
            ->set('name', 'Teszt Elek')
            ->set('phone', '+36301234567')
            ->set('email', 'teszt.elek@example.com')
            ->set('privacy', true)
            ->call('submitForm')
            ->assertHasNoErrors()
            ->assertDispatched('notify', fn (string $event, array $params): bool => $params['type'] === 'success'
                && str_contains((string) $params['body'], 'teszt.elek@example.com'));

        $recipients = resolve(Mailer::class)->getSymfonyTransport()->messages()
            ->map(fn (SentMessage $sent): string => $sent->getOriginalMessage()->getTo()[0]->getAddress());

        $this->assertContains('teszt.elek@example.com', $recipients);
    }

    public function test_toast_component_shows_a_flashed_toast_after_redirect(): void
    {
        // Controller redirects flash "toast"; the component must pick it up on the next page load.
        session()->flash('toast', ['type' => 'success', 'title' => 'Sikeres küldés', 'body' => 'Visszaigazoló e-mail elküldve.']);

        $html = Blade::render('<x-toast />');

        $this->assertStringContainsString('x-on:notify.window', $html);
        $this->assertStringContainsString('x-init="add(', $html);
        $this->assertStringContainsString('Sikeres', $html);
    }
}
