<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
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

        $response = $this->post('/kapcsolat', [
            'name' => 'Teszt Elek',
            'email' => 'teszt.elek@example.com',
            'phone' => '+36 30 123 4567',
            'company' => '',
            'contact_subject' => 'Teszt ingatlan',
            'message' => 'Érdekelne az iroda.',
            'privacy' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');

        $emails = app('mailer')->getSymfonyTransport()->messages()
            ->map(fn (SentMessage $sent): Email => $sent->getOriginalMessage());
        $adminEmail = $emails->first(fn (Email $email): bool => $email->getTo()[0]->getAddress() === config('mail.admin_address'));

        $this->assertNotNull($adminEmail);
        $this->assertSame('weboldal@psg-irodahazak.hu', $adminEmail->getFrom()[0]->getAddress());
        $this->assertSame('teszt.elek@example.com', $adminEmail->getReplyTo()[0]->getAddress());
        Log::shouldHaveReceived('info')->with('Contact form emails sent', Mockery::type('array'))->once();
    }
}
