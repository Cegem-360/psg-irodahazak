<?php

declare(strict_types=1);

use App\Livewire\ListRentOffices;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(ListRentOffices::class)
        ->assertStatus(200);
});
