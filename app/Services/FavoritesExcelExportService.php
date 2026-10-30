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
            'A3' => 'Irodaház neve',
            'B3' => 'Irodaház címe',
            'C3' => 'Építés éve',
            'D3' => 'Bérleti díj',
            'E3' => 'Üzemeltetési díj',
            'F3' => 'Közös területi arány',
            'G3' => 'Parkolóhely díja',
            'H3' => 'Min. bérleti időszak',
            'I3' => 'Ajánlott terület',
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
            $property->postal_code ?? '',
            $property->city ?? '',
            $property->street ?? '',
            $property->street_type ?? '',
            $property->house_number ?? '',
        ));
    }

    private function formatRentalFee(Property $property): string
    {
        $min = $property->min_rent;
        $max = $property->max_rent;
        $addons = $property->min_rent_unit ?? '';

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
        $value = $property->operating_fee;
        $addons = $property->operating_fee_unit ?? '';

        if (! $value) {
            return '';
        }

        return mb_trim(translate_value($value).' '.$addons);
    }

    private function formatCommonAreaRatio(Property $property): string
    {
        $value = $property->common_area_ratio;
        $addons = $property->common_area_ratio_unit ?? '';

        if (! $value) {
            return '';
        }

        return mb_trim($value.' '.$addons);
    }

    private function formatParkingFee(Property $property): string
    {
        $min = $property->min_parking_fee;
        $max = $property->max_parking_fee;
        $addons = $property->min_parking_fee_unit ?? '';

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
        $value = $property->min_lease_term;
        $addons = $property->min_lease_term_unit ?? '';

        if (! $value) {
            return '';
        }

        return mb_trim($value.' '.$addons);
    }
}
