<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Sends a contact-form message: a copy to the office and to the managing director,
 * both from the website's own address with the visitor as reply-to, and a
 * confirmation to the visitor.
 */
final class SendContactMessage
{
    /**
     * @return array<string, string>
     */
    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'contact_subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'privacy' => 'required|accepted',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function messages(): array
    {
        return [
            'name.required' => __('Please enter your name.'),
            'email.required' => __('Please enter your email address.'),
            'email.email' => __('Please enter a valid email address.'),
            'phone.required' => __('Please enter your phone number.'),
            'contact_subject.required' => __('Please choose a subject.'),
            'message.required' => __('Please enter your message.'),
            'privacy.required' => __('You must accept the privacy policy.'),
            'privacy.accepted' => __('You must accept the privacy policy.'),
        ];
    }

    /**
     * @param  array{name: string, email: string, phone: string, company?: string|null, contact_subject: string, message: string}  $data
     */
    public function handle(array $data): void
    {
        $mailData = [...$data, 'userMessage' => $data['message']];
        unset($mailData['message'], $mailData['privacy']);

        foreach ([config('mail.admin_address'), config('mail.agent_address')] as $recipient) {
            Mail::send('emails.contact', $mailData, function ($message) use ($mailData, $recipient): void {
                $message->from(config('mail.notification_from.address'), config('mail.notification_from.name'))
                    ->to($recipient)
                    ->subject('Új kapcsolatfelvételi üzenet: '.$mailData['contact_subject'])
                    ->replyTo($mailData['email'], $mailData['name']);
            });
        }

        Mail::send('emails.contact-confirmation', $mailData, function ($message) use ($mailData): void {
            $message->to($mailData['email'], $mailData['name'])
                ->subject('Kapcsolatfelvételi üzenet megerősítése - PSG Irodaházak');
        });

        Log::info('Contact form emails sent', [
            'email' => $mailData['email'],
            'contact_subject' => $mailData['contact_subject'],
        ]);
    }
}
