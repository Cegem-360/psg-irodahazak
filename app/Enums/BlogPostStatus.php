<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Whether a blog post is live, waiting for its publication date, or not published.
 */
enum BlogPostStatus: string implements HasColor, HasLabel
{
    case Published = 'published';
    case Scheduled = 'scheduled';
    case Draft = 'draft';

    public function getLabel(): string
    {
        return match ($this) {
            self::Published => 'Publikált',
            self::Scheduled => 'Ütemezett',
            self::Draft => 'Vázlat',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Published => 'success',
            self::Scheduled => 'warning',
            self::Draft => 'gray',
        };
    }
}
