<?php

declare(strict_types=1);

use App\Models\Translate;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// The "translates" table is imported externally and has no migration, so it is
// created (and emptied) here to exercise the database-backed lookup branch.
beforeEach(function (): void {
    if (! Schema::hasTable('translates')) {
        Schema::create('translates', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->nullable();
            $table->text('translated')->nullable();
            $table->string('lang')->default('EN');
            $table->timestamp('date')->nullable();
            $table->timestamps();
        });
    }

    Translate::query()->delete();
});

it('returns the value unchanged for non-english locales', function (): void {
    app()->setLocale('hu');
    Translate::create(['name' => 'Bruttó', 'translated' => 'Gross']);

    expect(translate_value('Bruttó'))->toBe('Bruttó');
});

it('returns the english translation when one exists', function (): void {
    app()->setLocale('en');
    Translate::create(['name' => 'Bruttó', 'translated' => 'Gross']);

    expect(translate_value('Bruttó'))->toBe('Gross');
});

it('falls back to the original free-text value when no translation exists', function (): void {
    app()->setLocale('en');

    expect(translate_value('Egyedi szöveg'))->toBe('Egyedi szöveg');
});

it('falls back to the original value when the translation is empty', function (): void {
    app()->setLocale('en');
    Translate::create(['name' => 'Bruttó', 'translated' => '']);

    expect(translate_value('Bruttó'))->toBe('Bruttó');
});

it('passes null and empty strings through unchanged', function (): void {
    app()->setLocale('en');

    expect(translate_value(null))->toBeNull()
        ->and(translate_value(''))->toBe('');
});
