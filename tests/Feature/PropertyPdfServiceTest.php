<?php

declare(strict_types=1);

use App\Models\Property;
use App\Services\PropertyPdfService;

it('launches chromium without sandbox for the printable property pdf', function (): void {
    $property = Property::factory()->create();

    $command = (new PropertyPdfService)->browsershotForView($property)->createPdfCommand();

    expect($command['options']['args'])
        ->toContain('--no-sandbox')
        ->toContain('--disable-web-security');
});
