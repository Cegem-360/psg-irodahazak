<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Property;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class PropertyPdfService
{
    public function generatePdf(Property $property): StreamedResponse
    {
        // Betöltjük a kapcsolódó képek adatokat
        $property->load(['images']);

        // HTML tartalom generálása
        $html = view('pdf.property', ['property' => $property])->render();

        // PDF generálás Browsershot segítségével
        $footerHtml = view('pdf.footer')->render();

        $pdf = Browsershot::html($html)
            ->addChromiumArguments([
                '--allow-file-access-from-files',
            ])
            ->format(config('pdf.browsershot.format', 'A4'))
            ->margins(
                config('pdf.browsershot.margins.top', 15),
                config('pdf.browsershot.margins.right', 15),
                config('pdf.browsershot.margins.bottom', 25), // Alsó margó nagyobb a footer miatt
                config('pdf.browsershot.margins.left', 15)
            )
            ->showBackground()
            ->waitUntilNetworkIdle(config('pdf.browsershot.wait_until_network_idle', true))
            ->timeout(config('pdf.browsershot.timeout', 90))
            ->delay(2000) // 2 másodperc várakozás a Tailwind betöltésére
            ->showBrowserHeaderAndFooter()
            ->footerHtml($footerHtml);

        // Fájlnév generálása
        $filename = $this->generateFilename($property);

        // PDF letöltés streamelt válaszként
        return new StreamedResponse(function () use ($pdf): void {
            echo $pdf->pdf();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function savePdf(Property $property, ?string $path = null): string
    {
        // Betöltjük a kapcsolódó képek adatokat
        $property->load(['images']);

        // HTML tartalom generálása
        $html = view('pdf.property', ['property' => $property])->render();

        // Alapértelmezett útvonal ha nincs megadva
        if (! $path) {
            $path = 'pdfs/properties/'.$this->generateFilename($property);
        }

        // PDF generálás és mentés
        $footerHtml = view('pdf.footer')->render();

        $pdf = Browsershot::html($html)
            ->addChromiumArguments([
                '--allow-file-access-from-files',
                'font-render-hinting' => 'none',
            ])
            ->format(config('pdf.browsershot.format', 'A4'))
            ->margins(
                config('pdf.browsershot.margins.top', 15),
                config('pdf.browsershot.margins.right', 15),
                config('pdf.browsershot.margins.bottom', 25), // Alsó margó nagyobb a footer miatt
                config('pdf.browsershot.margins.left', 15)
            )
            ->showBackground()
            ->waitUntilNetworkIdle(config('pdf.browsershot.wait_until_network_idle', true))
            ->timeout(config('pdf.browsershot.timeout', 90))
            ->delay(2000) // 2 másodperc várakozás a Tailwind betöltésére
            ->footerHtml($footerHtml)
            ->pdf();

        // Fájl mentése
        Storage::disk('public')->put($path, $pdf);

        return $path;
    }

    public function generatePdfForView(Property $property): Response
    {
        // Betöltjük a kapcsolódó képek adatokat
        $property->load(['images']);

        // HTML tartalom generálása
        $html = view('pdf.property', ['property' => $property])->render();

        // PDF generálás Browsershot segítségével
        $footerHtml = view('pdf.footer')->render();

        $pdf = Browsershot::html($html)
            ->setNodeBinary('/home/psgiroda/nodevenv/puppeteer/24/bin/node')
            ->setNpmBinary('/home/psgiroda/nodevenv/puppeteer/24/bin/npm')
            ->setOption('args', ['--disable-web-security'])
            ->format(config('pdf.browsershot.format', 'A4'))
            ->margins(
                config('pdf.browsershot.margins.top', 15),
                config('pdf.browsershot.margins.right', 15),
                config('pdf.browsershot.margins.bottom', 25), // Alsó margó nagyobb a footer miatt
                config('pdf.browsershot.margins.left', 15)
            )
            ->showBackground()
            ->waitUntilNetworkIdle(config('pdf.browsershot.wait_until_network_idle', true))
            ->timeout(config('pdf.browsershot.timeout', 90))
            ->delay(2000) // 2 másodperc várakozás a Tailwind betöltésére
            ->footerHtml($footerHtml)
            ->pdf();

        // Fájlnév generálása
        $filename = $this->generateFilename($property);

        // PDF megjelenítése böngészőben (nem letöltés)
        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="'.$filename.'"');
    }

    private function generateFilename(Property $property): string
    {
        $title = $property->title ? str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $property->title) : 'ingatlan';
        $date = now()->format('Y_m_d_H_i');

        return sprintf('ingatlan_%s_%s.pdf', $title, $date);
    }
}
