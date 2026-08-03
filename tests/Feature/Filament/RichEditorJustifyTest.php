<?php

declare(strict_types=1);

use App\Filament\Resources\BlogPostResource\Pages\CreateBlogPost;
use App\Filament\Resources\TestimonialResource\Pages\CreateTestimonial;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\RichEditor;
use Tests\TestCase;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    /** @var TestCase $this */
    Filament::setCurrentPanel('admin');
    $this->actingAs(User::factory()->create());
});

it('adds the justify button next to the other alignment buttons by default', function (): void {
    livewire(CreateTestimonial::class)
        ->assertFormFieldExists('testimonial', checkFieldUsing: function (RichEditor $field): bool {
            $alignmentGroup = collect($field->getToolbarButtons())
                ->first(fn (array $buttonGroup): bool => in_array('alignEnd', $buttonGroup, true));

            expect($alignmentGroup)->toBe(['alignStart', 'alignCenter', 'alignEnd', 'alignJustify']);

            return true;
        });
});

it('offers the justify button on editors with a custom toolbar', function (): void {
    livewire(CreateBlogPost::class)
        ->assertFormFieldExists(
            'content',
            checkFieldUsing: fn (RichEditor $field): bool => $field->hasToolbarButton('alignJustify'),
        );
});
