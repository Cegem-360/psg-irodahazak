<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Livewire\ContactForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;
use Mockery;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\Email;
use Tests\TestCase;

final class ContactFormMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_notification_is_sent_from_a_separate_website_address(): void
    {
        // Gmail files mail "from yourself" under Sent, so the admin copy must not come from the admin address.
        Log::spy();

        Livewire::test(ContactForm::class)
            ->set('name', 'Teszt Elek')
            ->set('email', 'teszt.elek@example.com')
            ->set('phone', '+36 30 123 4567')
            ->set('contact_subject', 'Teszt ingatlan')
            ->set('message', 'Érdekelne az iroda.')
            ->set('privacy', true)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('sent', true)
            ->assertSet('message', '')
            ->assertDispatched('notify', type: 'success');

        $emails = resolve(Mailer::class)->getSymfonyTransport()->messages()
            ->map(fn (SentMessage $sent): Email => $sent->getOriginalMessage());
        $adminEmail = $emails->first(fn (Email $email): bool => $email->getTo()[0]->getAddress() === config('mail.admin_address'));

        $this->assertCount(3, $emails);
        $this->assertNotNull($adminEmail);
        $this->assertSame('weboldal@psg-irodahazak.hu', $adminEmail->getFrom()[0]->getAddress());
        $this->assertSame('teszt.elek@example.com', $adminEmail->getReplyTo()[0]->getAddress());
        Log::shouldHaveReceived('info')->with('Contact form emails sent', Mockery::type('array'))->once();
    }

    public function test_invalid_submission_shows_errors_and_sends_nothing(): void
    {
        Livewire::test(ContactForm::class)
            ->set('email', 'nem-email')
            ->call('submit')
            ->assertHasErrors(['name' => 'required', 'email' => 'email', 'privacy' => 'accepted'])
            ->assertSee('A név megadása kötelező.')
            ->assertSet('sent', false);

        $this->assertCount(0, resolve(Mailer::class)->getSymfonyTransport()->messages());
    }
}
