<?php

declare(strict_types=1);

use App\Enums\InquirySubject;
use App\Livewire\ContactForm;
use App\Models\Property;
use Livewire\Livewire;

/*
 * The privacy consent checkbox toggles fine, but @tailwindcss/forms renders the
 * checkmark as a white glyph on top of the checkbox background. The `bg-gray-50`
 * utility overrides the plugin's checked background-color, leaving a white check
 * on a light-gray box — invisible, so users think the checkbox "won't tick".
 * A checked-state background utility must keep the checked state visible.
 */
test('contact form privacy checkbox renders a visible checked state', function (): void {
    Livewire::test(ContactForm::class)
        ->assertSeeHtml('id="contact_privacy"')
        ->assertSeeHtml('checked:bg-primary');
});

test('contact form on a property page preselects the building as subject', function (): void {
    $property = Property::query()->forceCreate([
        'title' => 'Bank Center',
        'slug' => 'bank-center',
        'status' => 'active',
        'elado_v_kiado' => 'kiado-iroda',
    ]);

    Livewire::test(ContactForm::class, ['selectedPropertyId' => $property->id, 'selectedPropertyTypeIsRent' => true])
        ->assertSet('contact_subject', 'Bank Center')
        ->assertSeeHtml('<option value="Bank Center">Bank Center</option>');
});

test('contact form on the contact page offers the general subjects', function (): void {
    Livewire::test(ContactForm::class)
        ->assertSeeHtml('value="'.InquirySubject::OfficeSearch->getLabel().'"')
        ->assertSet('contact_subject', '');
});
