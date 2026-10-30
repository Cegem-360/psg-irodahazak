<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

final class FavoritesSendMail extends Mailable
{
    /**
     * @param  Collection<int, Property>  $properties
     */
    public function __construct(
        public string $recipientName,
        public string $bodyText,
        public Collection $properties,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: __('You have received an online office building offer!'));
    }

    public function content(): Content
    {
        return new Content(view: 'emails.favorites-send');
    }
}
