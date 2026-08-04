<?php

declare(strict_types=1);

use App\Models\Property;

it('writes a sitemap with the static pages and published properties', function (): void {
    // forceCreate rather than the factory: PropertyFactory is still an empty stub
    // and the model does not use HasFactory.
    $property = Property::query()->forceCreate([
        'title' => 'Teszt ingatlan',
        'status' => 'active',
        'slug' => 'teszt-ingatlan-sitemap',
        'elado_v_kiado' => 'kiado',
    ]);

    $hidden = Property::query()->forceCreate([
        'title' => 'Nem aktív ingatlan',
        'status' => 'inactive',
        'slug' => 'nem-aktiv-ingatlan',
        'elado_v_kiado' => 'kiado',
    ]);

    $path = sys_get_temp_dir().'/sitemap-test-'.bin2hex(random_bytes(6)).'.xml';

    $this->artisan('sitemap:generate', ['--path' => $path])->assertSuccessful();

    $xml = (string) file_get_contents($path);
    @unlink($path);

    expect($xml)->toContain('<urlset')
        ->and($xml)->toContain(route('properties.show', ['property' => $property->slug]))
        ->and($xml)->toContain(url('/kapcsolat'))
        ->and($xml)->not->toContain($hidden->slug)
        ->and($xml)->not->toContain('/admin');
});
