<?php

declare(strict_types=1);

use App\Enums\InquirySubject;
use App\Enums\QuoteRequestStatus;
use App\Filament\Resources\QuoteRequestResource;
use App\Filament\Resources\QuoteRequestResource\Pages\ListQuoteRequests;
use App\Livewire\QuoteRequestModal;
use App\Models\QuoteRequest;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Tests\TestCase;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    /** @var TestCase $this */
    Filament::setCurrentPanel('admin');
    $this->actingAs(User::factory()->create());
});

function quoteRequest(array $attributes = []): QuoteRequest
{
    return QuoteRequest::query()->create([
        'name' => 'Teszt Elek',
        'phone' => '+36301234567',
        'email' => 'teszt.elek@example.com',
        ...$attributes,
    ]);
}

it('starts a quote request as new', function (): void {
    expect(quoteRequest()->refresh()->status)->toBe(QuoteRequestStatus::New)
        ->and(QuoteRequestResource::getNavigationBadge())->toBe('1');
});

it('lists quote requests with their status label and filters by status', function (): void {
    $new = quoteRequest();
    $closed = quoteRequest(['status' => QuoteRequestStatus::Closed]);

    livewire(ListQuoteRequests::class)
        ->assertCanSeeTableRecords([$new, $closed])
        ->assertSee(['Új', 'Lezárva'])
        ->filterTable('status', QuoteRequestStatus::Closed->value)
        ->assertCanSeeTableRecords([$closed])
        ->assertCanNotSeeTableRecords([$new]);
});

it('moves a request to contacted and then closed from the table', function (): void {
    $request = quoteRequest();

    livewire(ListQuoteRequests::class)->callTableAction('contact', $request);

    expect($request->refresh()->status)->toBe(QuoteRequestStatus::Contacted)
        ->and($request->contacted_at)->not->toBeNull();

    livewire(ListQuoteRequests::class)->callTableAction('close', $request);

    expect($request->refresh()->status)->toBe(QuoteRequestStatus::Closed);
});

it('stores the chosen topic as an enum and rejects anything else', function (): void {
    Livewire::test(QuoteRequestModal::class)
        ->set('name', 'Teszt Elek')
        ->set('phone', '+36301234567')
        ->set('email', 'teszt.elek@example.com')
        ->set('privacy', true)
        ->set('subject', 'nem-letezik')
        ->call('submitForm')
        ->assertHasErrors('subject')
        ->set('subject', InquirySubject::Consulting->value)
        ->call('submitForm')
        ->assertHasNoErrors();

    expect(QuoteRequest::query()->sole()->subject)->toBe(InquirySubject::Consulting);
});
