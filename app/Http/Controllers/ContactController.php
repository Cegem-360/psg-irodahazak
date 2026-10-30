<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ContactPage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function show(): Factory|View
    {
        $contactPage = ContactPage::getActiveByLanguage(app()->getLocale());

        return view('pages.contact', ['contactPage' => $contactPage]);
    }
}
