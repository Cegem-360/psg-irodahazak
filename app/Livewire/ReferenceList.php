<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Reference;
use Livewire\Component;

final class ReferenceList extends Component
{
    public function render()
    {
        $references = Reference::active()
            ->ordered()
            ->get();

        return view('livewire.reference-list', [
            'references' => $references,
        ]);
    }
}
