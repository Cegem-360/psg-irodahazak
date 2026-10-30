<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * The 23 districts of Budapest. The case name is the Roman numeral the district is
 * known by ("XIII. kerület"), the value its number.
 */
enum BudapestDistrict: int
{
    case I = 1;
    case II = 2;
    case III = 3;
    case IV = 4;
    case V = 5;
    case VI = 6;
    case VII = 7;
    case VIII = 8;
    case IX = 9;
    case X = 10;
    case XI = 11;
    case XII = 12;
    case XIII = 13;
    case XIV = 14;
    case XV = 15;
    case XVI = 16;
    case XVII = 17;
    case XVIII = 18;
    case XIX = 19;
    case XX = 20;
    case XXI = 21;
    case XXII = 22;
    case XXIII = 23;

    /**
     * Reads a district as it is stored or requested: its number ("5") or its
     * Roman numeral ("V", case-insensitive).
     */
    public static function tryFromName(string $district): ?self
    {
        $district = mb_strtoupper(mb_trim($district));

        if (ctype_digit($district)) {
            return self::tryFrom((int) $district);
        }

        return array_find(self::cases(), fn (self $case): bool => $case->name === $district);
    }

    /**
     * The district a four-digit Budapest postal code belongs to: 1054 → V.
     */
    public static function tryFromPostalCode(string $postalCode): ?self
    {
        if (mb_strlen($postalCode) !== 4 || ! ctype_digit($postalCode)) {
            return null;
        }

        return self::tryFrom(intdiv((int) $postalCode, 10) - 100);
    }

    public function roman(): string
    {
        return $this->name;
    }
}
