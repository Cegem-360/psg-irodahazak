<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\Property;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * /ingatlanok: every active property, filtered by the query string.
 */
final class PropertyIndex extends Component
{
    use RendersAsPage;
    use WithPagination;

    public function render(): View
    {
        $query = Property::query()->active();

        // Filter by districts (multiple)
        if (request('districts')) {
            $districts = explode(',', (string) request('districts'));
            $districts = array_map(trim(...), $districts); // Remove any extra whitespace
            $districts = array_filter($districts); // Remove empty values

            if ($districts !== []) {
                $query->where(function ($q) use ($districts): void {
                    foreach ($districts as $district) {
                        $q->orWhere('city', 'like', '%'.$district.'%');
                    }
                });
            }
        }

        // Filter by district (single - for backward compatibility)
        if (request('district') && ! request('districts')) {
            $query->where('city', 'like', '%'.request('district').'%');
        }

        // Filter by office building name
        if (request('office_name')) {
            $query->where('title', 'like', '%'.request('office_name').'%');
        }

        // Filter by search term
        if (request('search')) {
            $query->where(function ($q): void {
                $q->where('title', 'like', '%'.request('search').'%')
                    ->orWhere('content', 'like', '%'.request('search').'%');
            });
        }

        // Filter by area range
        if (request('area_min') || request('area_max')) {
            $areaMin = request('area_min', 0);
            $areaMax = request('area_max', 9999999);
            $query->whereBetween('total_area', [$areaMin, $areaMax]);
        }

        // Filter by rental price range
        if (request('price_min') || request('price_max')) {
            $priceMin = request('price_min', 0);
            $priceMax = request('price_max', 9999999);
            $query->whereBetween('max_rent', [$priceMin, $priceMax]);
        }

        // Filter by rental properties only if rental filter is applied
        if (request('type') === 'rent') {
            $query->rent();
        }

        $properties = $query->orderBy('ord')->paginate(12);

        return $this->asPage(view('properties.index', ['properties' => $properties]));
    }
}
