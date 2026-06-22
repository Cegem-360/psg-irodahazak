<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Reference;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class ReferenceList extends Component
{
    public function render(): Factory|View
    {
        $references = Reference::active()
            ->ordered()
            ->get();

        return view('livewire.reference-list', [
            'references' => $references,
        ]);
    }
}
