<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class CategoryController extends Controller
{
    /**
     * A /budapest/{category} listing page.
     */
    public function show(string $category): View|RedirectResponse
    {
        if ($category === 'elado-irodak') {
            return to_route(request()->routeIs('en.*') ? 'en.elado-irodahazak' : 'elado-irodahazak');
        }

        $categoryModel = Category::query()->where('slug', $category)->first();

        abort_if($categoryModel === null, 404);

        return view('pages.filter', [
            'queryParams' => ['category' => $category],
            'category' => $categoryModel,
        ]);
    }
}
