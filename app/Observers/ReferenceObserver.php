<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Reference;
use Illuminate\Support\Facades\Storage;

final class ReferenceObserver
{
    public function updating(Reference $reference): void
    {
        if ($reference->isDirty('image') && $reference->getOriginal('image')) {
            Storage::delete($reference->getOriginal('image'));
        }
    }

    public function deleted(Reference $reference): void
    {
        if ($reference->image) {
            Storage::delete($reference->image);
        }
    }
}
