<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use Illuminate\Contracts\View\View;

/**
 * Full-page components render into the site layout. The page's title and meta
 * tags are named slots in its view; the breadcrumb trail is set here.
 */
trait RendersAsPage
{
    /**
     * @param  list<array{name: string, url: string}>  $trail  the crumbs after "Homepage"
     */
    protected function asPage(View $view, array $trail = []): View
    {
        return $view->layout('components.layouts.app', [
            'breadcrumbs' => [['name' => __('Homepage'), 'url' => localized_route('home')], ...$trail],
        ]);
    }
}
