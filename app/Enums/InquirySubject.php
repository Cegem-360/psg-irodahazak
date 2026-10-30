<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * The general topics a visitor can pick on the quote request and contact forms.
 */
enum InquirySubject: string implements HasLabel
{
    case OfficeSearch = 'office_search';
    case OfficeRental = 'office_rental';
    case PropertyValuation = 'property_valuation';
    case Investment = 'investment';
    case Consulting = 'consulting';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::OfficeSearch => __('Office search'),
            self::OfficeRental => __('Office rental'),
            self::PropertyValuation => __('Property valuation'),
            self::Investment => __('Investment opportunity'),
            self::Consulting => __('Consulting'),
            self::Other => __('Other'),
        };
    }
}
