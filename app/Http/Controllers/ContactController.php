<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Property;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Log;

final class ContactController extends Controller
{
    /**
     * Store a newly created contact message.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'selected_property_id' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'privacy' => 'required|accepted',
        ], [
            'name.required' => 'A név megadása kötelező.',
            'email.required' => 'Az email cím megadása kötelező.',
            'email.email' => 'Kérjük, adjon meg egy érvényes email címet.',
            'phone.required' => 'A telefonszám megadása kötelező.',
            'selected_property_id.required' => 'Ingatlan megadása kötelező.',
            'message.required' => 'Az üzenet megadása kötelező.',
            'privacy.required' => 'Az adatvédelmi nyilatkozat elfogadása kötelező.',
            'privacy.accepted' => 'Az adatvédelmi nyilatkozat elfogadása kötelező.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Kérjük, javítsa ki a hibákat és próbálja újra.');
        }

        $validated = $validator->validated();
        $validated['property_title'] = Property::find($validated['selected_property_id'])->title ?? 'Nincs megadva';
        $validated['userMessage'] = $validated['message'];
        unset($validated['message']);
        try {
            // Send email notification to admin
            Mail::send('emails.contact', $validated, function ($message) use ($validated): void {
                $message->to(env('ADMIN_EMAIL', 'info@psg-irodahazak.hu'))
                    ->subject('Új kapcsolatfelvételi üzenet: '.$validated['property_title'])
                    ->replyTo($validated['email'], $validated['name']);
            });

            // Send confirmation email to user
            Mail::send('emails.contact-confirmation', $validated, function ($message) use ($validated): void {
                $message->to($validated['email'], $validated['name'])
                    ->subject('Kapcsolatfelvételi üzenet megerősítése - PSG Irodaházak');
            });

            return back()->with('success', 'Köszönjük üzenetét! Hamarosan felvesszük Önnel a kapcsolatot.');

        } catch (Exception $exception) {
            Log::error('Contact form email sending failed', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
                'data' => $validated,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Hiba történt az üzenet küldése során. Kérjük, próbálja újra később vagy hívjon minket telefonon.');
        }
    }
}
