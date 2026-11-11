<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Services\LocalizedRoutes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Prepares the head of the site layout from the page's named slots (title,
 * metaDescription, meta, metaRobots): the page title and description text, the
 * hreflang alternates, the robots value, and a check whether the page's own
 * "meta" slot already carries a tag, which then replaces the layout's default.
 */
final readonly class SiteLayoutComposer
{
    public function __construct(
        private LocalizedRoutes $localizedRoutes,
        private Request $request,
    ) {}

    public function compose(View $view): void
    {
        $data = $view->getData();
        $route = $this->request->route();
        $isTranslated = $this->localizedRoutes->isTranslated((string) $route?->getName());
        $metaSlotHtml = isset($data['meta']) ? (string) $data['meta'] : '';

        $view->with([
            'alternateUrls' => $isTranslated ? $this->localizedRoutes->alternates($route) : [],
            'metaRobots' => $data['metaRobots'] ?? ($isTranslated || app()->getLocale() === LocalizedRoutes::DEFAULT_LOCALE ? null : 'noindex, follow'),
            'metaSlotHas' => fn (string $needle): bool => str_contains($metaSlotHtml, $needle),
            'pageTitleText' => $this->squishedText($data['title'] ?? null) ?: __('page.title.default'),
            'pageDescriptionText' => $this->description($data['metaDescription'] ?? null, $metaSlotHtml),
        ]);
    }

    /**
     * The metaDescription slot, else the description tag of the "meta" slot, else the site default.
     */
    private function description(mixed $metaDescriptionSlot, string $metaSlotHtml): string
    {
        $description = $this->squishedText($metaDescriptionSlot);

        if ($description === '' && preg_match('/name="description"\s+content="([^"]*)"/', $metaSlotHtml, $slotDescription)) {
            $description = html_entity_decode($slotDescription[1]);
        }

        return $description ?: __('Offices for rent in Budapest! Rent from traditional and serviced offices on favourable lease terms, with an overview of the entire office market database. Offers sent the same day.');
    }

    private function squishedText(mixed $slot): string
    {
        return Str::squish($slot !== null ? strip_tags((string) $slot) : '');
    }
}
