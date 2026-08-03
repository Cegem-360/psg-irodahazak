<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

/*
 * The privacy consent checkbox toggles fine, but @tailwindcss/forms renders the
 * checkmark as a white glyph on top of the checkbox background. The `bg-gray-50`
 * utility overrides the plugin's checked background-color, leaving a white check
 * on a light-gray box — invisible, so users think the checkbox "won't tick".
 * A checked-state background utility must keep the checked state visible.
 */
test('contact form privacy checkbox renders a visible checked state', function (): void {
    // The @error directives need a shared error bag, normally provided by web middleware.
    View::share('errors', new ViewErrorBag);

    $html = Blade::render('<x-forms.contact />');

    expect($html)->toContain('id="contact_privacy"');
    expect($html)->toContain('checked:bg-primary');
});

/*
 * After a successful submission the controller redirects back with a flashed
 * `success` message. The reusable contact form component must render it so the
 * visitor gets a confirmation ("Köszönjük üzenetét! ...") on property pages,
 * not only on the standalone contact page.
 */
test('contact form component displays the flashed success message', function (): void {
    View::share('errors', new ViewErrorBag);
    session()->flash('success', 'Köszönjük üzenetét! Hamarosan felvesszük Önnel a kapcsolatot.');

    $html = Blade::render('<x-forms.contact />');

    expect($html)->toContain('Köszönjük üzenetét! Hamarosan felvesszük Önnel a kapcsolatot.');
});
