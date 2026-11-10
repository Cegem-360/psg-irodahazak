<?php

declare(strict_types=1);

use App\Livewire\Office\RentListing;
use App\Models\Property;
use App\Models\Tag;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;
use Tests\TestCase;

it('renders successfully', function (): void {
    Livewire::test(RentListing::class)
        ->assertStatus(200);
});

it('lists the offices with the fan-coil tag when searching for a fan-coil type, with or without accents', function (string $search): void {
    $twoPipe = Property::factory()->create();
    $fourPipe = Property::factory()->create();
    $twoPipe->tags()->attach(Tag::query()->create(['name' => '2 csöves fan-coil légkondicionálás']));
    $fourPipe->tags()->attach(Tag::query()->create(['name' => '4 csöves fan-coil légkondicionálás']));

    $offices = Livewire::withQueryParams(['search' => $search])->test(RentListing::class)->instance()->getOffices();

    expect($offices->pluck('id')->all())->toBe([$twoPipe->id]);
})->with(['2 csöves', '2 csoves fan-coil', '2 CSÖVES hűtés']);

it('answers 404 for a category that does not exist', function (): void {
    /** @var TestCase $this */
    $this->get('/kiado-irodak?category=nem-letezik')->assertNotFound();
});

it('lists the offices without a fitting area last when no area is asked for, with or without the search form', function (array $query): void {
    $noArea = Property::factory()->create(['title' => 'A terület nélkül', 'available_area' => null, 'min_available_area' => null]);
    $tooLarge = Property::factory()->create(['title' => 'B nagy', 'available_area' => 9000, 'min_available_area' => 5000]);
    $fitting = Property::factory()->create(['title' => 'C megfelelő', 'available_area' => 500, 'min_available_area' => 100]);

    $list = Livewire::withQueryParams($query)->test(RentListing::class);

    expect($list->instance()->getOffices()->pluck('id')->all())->toBe([$fitting->id, $noArea->id, $tooLarge->id])
        ->and($list->get('totalOffices'))->toBe(3);
})->with([
    'without the form' => [[]],
    'form sent, slider untouched' => [['area_min' => null, 'area_max' => null]],
    'form sent, slider at its full range' => [['area_min' => '0', 'area_max' => '3000']],
]);

it('leaves out the offices outside the area the visitor narrowed the slider to', function (): void {
    Property::factory()->create(['available_area' => null, 'min_available_area' => null]);
    Property::factory()->create(['available_area' => 9000, 'min_available_area' => 5000]);
    $fitting = Property::factory()->create(['available_area' => 500, 'min_available_area' => 100]);

    $offices = Livewire::withQueryParams(['area_min' => '200', 'area_max' => '1000'])->test(RentListing::class)->instance()->getOffices();

    expect($offices->pluck('id')->all())->toBe([$fitting->id]);
});

it('does not let the visitor change the filters', function (): void {
    Livewire::test(RentListing::class)->set('search', 'bármi');
})->throws(CannotUpdateLockedPropertyException::class);
