<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;

/**
 * The visitor's favorite properties, kept as a JSON list of ids in a cookie.
 * The cookie is left unencrypted (see bootstrap/app.php) because the browser
 * reads and writes it too, for the favorites counter.
 */
final class FavoriteProperties
{
    public const string COOKIE = 'property_favorites';

    private const int LIFETIME_MINUTES = 60 * 24 * 365;

    /**
     * @return list<int>
     */
    public function ids(): array
    {
        $decoded = json_decode((string) Cookie::get(self::COOKIE, '[]'), true);

        return is_array($decoded)
            ? array_values(array_unique(array_map(intval(...), array_filter($decoded, is_numeric(...)))))
            : [];
    }

    public function has(int $propertyId): bool
    {
        return in_array($propertyId, $this->ids(), true);
    }

    /**
     * The favorites that are still on the market.
     *
     * @return Collection<int, Property>
     */
    public function properties(): Collection
    {
        $ids = $this->ids();

        return $ids === [] ? new Collection : Property::query()->active()->whereIn('id', $ids)->get();
    }

    /**
     * Adds the property to the favorites or removes it, and returns the new list.
     *
     * @return list<int>
     */
    public function toggle(int $propertyId): array
    {
        $ids = $this->has($propertyId)
            ? array_values(array_diff($this->ids(), [$propertyId]))
            : [...$this->ids(), $propertyId];

        // Not HttpOnly: the browser script reads it for the counter, and an HttpOnly cookie would also block its writes.
        Cookie::queue(Cookie::make(self::COOKIE, (string) json_encode($ids), self::LIFETIME_MINUTES, httpOnly: false));

        return $ids;
    }

    public function clear(): void
    {
        Cookie::queue(Cookie::forget(self::COOKIE));
    }
}
