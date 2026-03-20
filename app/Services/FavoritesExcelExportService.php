<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Property;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class FavoritesExcelExportService
{
    /**
     * Generate an Excel file from a collection of Property models and return it as a download response.
     *
     * @param  Collection<int, Property>  $properties
     */
    public function generate(Collection $properties): StreamedResponse
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('munkafuzet');

        // Row 1: Title - PSG-IRODAHAZAK.HU merged across B1:H1
        $sheet->mergeCells('B1:H1');
        $sheet->setCellValue('B1', 'PSG-IRODAHAZAK.HU');
        $sheet->getStyle('B1')->getFont()
            ->setBold(true)
            ->setSize(14);
        $sheet->getStyle('B1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Row 2: Empty (default)

        // Row 3: Header row
        $headers = [
            'A3' => 'Irodahaz neve',
            'B3' => 'Irodahaz cime',
            'C3' => 'Epites eve',
            'D3' => 'Berleti dij',
            'E3' => 'Uzemeltetesi dij',
            'F3' => 'Kozos teruleti arany',
            'G3' => 'Parkolohely dija',
            'H3' => 'Min. berleti idoszak',
            'I3' => 'Ajanlott terulet',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Bold header row
        $sheet->getStyle('A3:I3')->getFont()->setBold(true);

        // Data rows starting from row 4
        $row = 4;
        foreach ($properties as $property) {
            $sheet->setCellValue('A'.$row, $property->title ?? '');
            $sheet->setCellValue('B'.$row, $this->formatAddress($property));
            $sheet->setCellValue('C'.$row, $property->construction_year ?? '');
            $sheet->setCellValue('D'.$row, $this->formatRentalFee($property));
            $sheet->setCellValue('E'.$row, $this->formatOperatingFee($property));
            $sheet->setCellValue('F'.$row, $this->formatCommonAreaRatio($property));
            $sheet->setCellValue('G'.$row, $this->formatParkingFee($property));
            $sheet->setCellValue('H'.$row, $this->formatMinRentalPeriod($property));
            // Column I (Ajanlott terulet) is left empty for user to fill manually

            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $filename = sprintf('PSG_IRODA_ajanlatok_%s.xlsx', now()->format('Y-m-d'));

        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(function () use ($writer): void {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    private function formatAddress(Property $property): string
    {
        return mb_trim(sprintf(
            '%s %s, %s %s %s',
            $property->cim_irsz ?? '',
            $property->cim_varos ?? '',
            $property->cim_utca ?? '',
            $property->cim_utca_addons ?? '',
            $property->cim_hazszam ?? '',
        ));
    }

    private function formatRentalFee(Property $property): string
    {
        $min = $property->min_berleti_dij;
        $max = $property->max_berleti_dij;
        $addons = $property->min_berleti_dij_addons ?? '';

        if (! $min) {
            return '';
        }

        $value = $min;

        if ($max && $max !== $min) {
            $value = $min.' - '.$max;
        }

        return mb_trim($value.' '.$addons);
    }

    private function formatOperatingFee(Property $property): string
    {
        $value = $property->uzemeletetesi_dij;
        $addons = $property->uzemeletetesi_dij_addons ?? '';

        if (! $value) {
            return '';
        }

        return mb_trim($value.' '.$addons);
    }

    private function formatCommonAreaRatio(Property $property): string
    {
        $value = $property->kozos_teruleti_arany;
        $addons = $property->kozos_teruleti_arany_addons ?? '';

        if (! $value) {
            return '';
        }

        return mb_trim($value.' '.$addons);
    }

    private function formatParkingFee(Property $property): string
    {
        $min = $property->min_parkolas_dija;
        $max = $property->max_parkolas_dija;
        $addons = $property->min_parkolas_dija_addons ?? '';

        if (! $min) {
            return '';
        }

        $value = $min;

        if ($max && $max !== $min) {
            $value = $min.' - '.$max;
        }

        return mb_trim($value.' '.$addons);
    }

    private function formatMinRentalPeriod(Property $property): string
    {
        $value = $property->min_berleti_idoszak;
        $addons = $property->min_berleti_idoszak_addons ?? '';

        if (! $value) {
            return '';
        }

        return mb_trim($value.' '.$addons);
    }
}
