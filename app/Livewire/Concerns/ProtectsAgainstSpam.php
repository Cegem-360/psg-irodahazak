<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use Illuminate\Support\Facades\RateLimiter;

/**
 * Honeypot field and per-IP rate limit for the public forms that send email.
 */
trait ProtectsAgainstSpam
{
    /** Hidden from people; a bot that fills every field fills this one too. */
    public string $website = '';

    /**
     * Whether the submission must be dropped. A filled honeypot is dropped silently,
     * a rate-limited visitor gets an error notification.
     */
    protected function isBlockedAsSpam(string $action, int $maxAttempts, int $decaySeconds): bool
    {
        if ($this->website !== '') {
            return true;
        }

        $key = $action.':'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $this->dispatch('notify',
                type: 'danger',
                title: __('Too many attempts'),
                body: __('Please try again in :minutes minutes.', ['minutes' => (int) ceil(RateLimiter::availableIn($key) / 60)]),
            );

            return true;
        }

        RateLimiter::hit($key, $decaySeconds);

        return false;
    }
}
