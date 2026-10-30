<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Mail;

/**
 * Stores a quote request and mails it to the office and to the broker, both
 * from the website's own address with the visitor as reply-to, plus a
 * confirmation to the visitor.
 */
final class SendQuoteRequest
{
    /**
     * @param  array{name: string, phone: string, email: string, company?: string|null, message?: string|null, subject?: string|null}  $data  the subject is an InquirySubject value, or empty
     */
    public function handle(array $data): QuoteRequest
    {
        $quoteRequest = QuoteRequest::query()->create([...$data, 'subject' => ($data['subject'] ?? '') ?: null]);
        $subjectLabel = $quoteRequest->subject?->getLabel();

        $mailData = [
            'name' => $quoteRequest->name,
            'phone' => $quoteRequest->phone,
            'email' => $quoteRequest->email,
            'company' => $quoteRequest->company,
            'subject' => $subjectLabel,
            'userMessage' => $quoteRequest->message,
            'quoteId' => $quoteRequest->id,
        ];

        foreach ([config('mail.admin_address'), config('mail.agent_address')] as $recipient) {
            Mail::send('emails.quote-request', $mailData, function ($message) use ($quoteRequest, $recipient, $subjectLabel): void {
                $message->from(config('mail.notification_from.address'), config('mail.notification_from.name'))
                    ->to($recipient)
                    ->subject($subjectLabel ?? 'Új árajánlat kérés érkezett')
                    ->replyTo($quoteRequest->email, $quoteRequest->name);
            });
        }

        Mail::send('emails.quote-confirmation', ['name' => $quoteRequest->name], function ($message) use ($quoteRequest): void {
            $message->to($quoteRequest->email, $quoteRequest->name)
                ->subject('Árajánlat kérés megerősítése - PSG Irodaházak');
        });

        return $quoteRequest;
    }
}
