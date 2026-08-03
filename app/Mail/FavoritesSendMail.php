<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class FavoritesSendMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public $recipientName, public $bodyText, public $properties) {}

    public function build()
    {
        return $this->subject('Online irodaház ajánlat érkezett!')
            ->view('emails.favorites-send');
    }
}
