<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * Whether a property is offered for rent or for sale (the `elado_v_kiado` column).
 */
enum PropertyType: string implements HasLabel
{
    case Rent = 'kiado-iroda';
    case Sale = 'elado-iroda';

    public function getLabel(): string
    {
        return match ($this) {
            self::Rent => 'Kiadó',
            self::Sale => 'Eladó',
        };
    }

    /**
     * The public page route of a property of this type.
     */
    public function showRoute(): string
    {
        return match ($this) {
            self::Rent => 'properties.show',
            self::Sale => 'properties.show-for-sale',
        };
    }
}
