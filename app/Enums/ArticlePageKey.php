<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * The article pages whose copy the site owner edits in the admin. Each has a
 * fixed route; the key ties the route's component to its record.
 */
enum ArticlePageKey: string implements HasLabel
{
    case RentalFees = 'rental-fees';
    case OperatingFee = 'operating-fee';

    public function getLabel(): string
    {
        return match ($this) {
            self::RentalFees => 'Irodabérleti díjak (díjsáv-oldal)',
            self::OperatingFee => 'Üzemeltetési díj cikk',
        };
    }

    public function url(): string
    {
        return route($this->value);
    }
}
