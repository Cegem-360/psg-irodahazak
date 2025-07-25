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

    public $recipientName;

    public $salutation;

    public $bodyText;

    public $properties;

    public function __construct($recipientName, $salutation, $bodyText, $properties)
    {
        $this->recipientName = $recipientName;
        $this->salutation = $salutation;
        $this->bodyText = $bodyText;
        $this->properties = $properties;
    }

    public function build()
    {
        return $this->subject('Online irodaház ajánlat érkezett!')
            ->view('emails.favorites-send');
    }
}
