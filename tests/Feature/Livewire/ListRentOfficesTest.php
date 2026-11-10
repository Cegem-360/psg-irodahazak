<?php

declare(strict_types=1);

use App\Livewire\Office\RentListing;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(RentListing::class)
        ->assertStatus(200);
});
