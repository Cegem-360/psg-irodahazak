<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Impresszum;
use Illuminate\View\View;

final class ImpresszumController extends Controller
{
    public function show(): View
    {
        $impresszum = Impresszum::getActive();

        return view('impresszum', ['impresszum' => $impresszum]);
    }
}
