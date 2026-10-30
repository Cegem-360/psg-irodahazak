<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Quote requests stored the subject as the label the visitor saw, in their
 * language; they now store the InquirySubject value.
 */
return new class extends Migration
{
    /** @var array<string, list<string>> */
    private const array LABELS = [
        'office_search' => ['Iroda keresése', 'Office search', 'iroda_keresese'],
        'office_rental' => ['Iroda kiadása', 'Office rental', 'Office rent', 'iroda_kiadas'],
        'property_valuation' => ['Ingatlan értékelés', 'Property valuation', 'ingatlan_ertekeles'],
        'investment' => ['Befektetési lehetőség', 'Befektetés', 'Investment opportunity', 'Investment', 'befektetes'],
        'consulting' => ['Tanácsadás', 'Consulting', 'tanacadas'],
        'other' => ['Egyéb', 'Other', 'egyeb'],
    ];

    public function up(): void
    {
        foreach (self::LABELS as $value => $labels) {
            DB::table('quote_requests')->whereIn('subject', $labels)->update(['subject' => $value]);
        }

        DB::table('quote_requests')->where('subject', '')->update(['subject' => null]);

        // Anything else (a building name, say) is kept in the message, under "other".
        DB::table('quote_requests')
            ->whereNotNull('subject')
            ->whereNotIn('subject', array_keys(self::LABELS))
            ->orderBy('id')
            ->each(function (object $quoteRequest): void {
                DB::table('quote_requests')->where('id', $quoteRequest->id)->update([
                    'subject' => 'other',
                    'message' => mb_trim('Tárgy: '.$quoteRequest->subject."\n".$quoteRequest->message),
                ]);
            });
    }

    public function down(): void
    {
        foreach (self::LABELS as $value => $labels) {
            DB::table('quote_requests')->where('subject', $value)->update(['subject' => $labels[0]]);
        }
    }
};
