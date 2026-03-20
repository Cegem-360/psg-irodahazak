<?php

declare(strict_types=1);

use App\Models\Property;
use App\Services\FavoritesExcelExportService;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

it('formats rental fee as single value when min and max are the same', function (): void {
    $property = new Property([
        'min_berleti_dij' => '12',
        'max_berleti_dij' => '12',
        'min_berleti_dij_addons' => 'EUR/m2/ho',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatRentalFee');

    expect($method->invoke($service, $property))->toBe('12 EUR/m2/ho');
});

it('formats rental fee as range when min and max differ', function (): void {
    $property = new Property([
        'min_berleti_dij' => '10',
        'max_berleti_dij' => '15',
        'min_berleti_dij_addons' => 'EUR/m2/ho',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatRentalFee');

    expect($method->invoke($service, $property))->toBe('10 - 15 EUR/m2/ho');
});

it('formats rental fee without addons', function (): void {
    $property = new Property([
        'min_berleti_dij' => '10',
        'max_berleti_dij' => '15',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatRentalFee');

    expect($method->invoke($service, $property))->toBe('10 - 15');
});

it('returns empty string for rental fee when min is missing', function (): void {
    $property = new Property;

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatRentalFee');

    expect($method->invoke($service, $property))->toBe('');
});

it('formats operating fee with addons', function (): void {
    $property = new Property([
        'uzemeletetesi_dij' => '3.5',
        'uzemeletetesi_dij_addons' => 'EUR/m2/ho',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatOperatingFee');

    expect($method->invoke($service, $property))->toBe('3.5 EUR/m2/ho');
});

it('returns empty string for operating fee when value is missing', function (): void {
    $property = new Property;

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatOperatingFee');

    expect($method->invoke($service, $property))->toBe('');
});

it('formats common area ratio with addons', function (): void {
    $property = new Property([
        'kozos_teruleti_arany' => '10',
        'kozos_teruleti_arany_addons' => '%',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatCommonAreaRatio');

    expect($method->invoke($service, $property))->toBe('10 %');
});

it('returns empty string for common area ratio when value is missing', function (): void {
    $property = new Property;

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatCommonAreaRatio');

    expect($method->invoke($service, $property))->toBe('');
});

it('formats parking fee as range when min and max differ', function (): void {
    $property = new Property([
        'min_parkolas_dija' => '100',
        'max_parkolas_dija' => '150',
        'min_parkolas_dija_addons' => 'EUR/hely/ho',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatParkingFee');

    expect($method->invoke($service, $property))->toBe('100 - 150 EUR/hely/ho');
});

it('formats parking fee as single value when min and max are the same', function (): void {
    $property = new Property([
        'min_parkolas_dija' => '120',
        'max_parkolas_dija' => '120',
        'min_parkolas_dija_addons' => 'EUR/hely/ho',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatParkingFee');

    expect($method->invoke($service, $property))->toBe('120 EUR/hely/ho');
});

it('returns empty string for parking fee when min is missing', function (): void {
    $property = new Property;

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatParkingFee');

    expect($method->invoke($service, $property))->toBe('');
});

it('formats minimum rental period with addons', function (): void {
    $property = new Property([
        'min_berleti_idoszak' => '5',
        'min_berleti_idoszak_addons' => 'ev',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatMinRentalPeriod');

    expect($method->invoke($service, $property))->toBe('5 ev');
});

it('returns empty string for minimum rental period when value is missing', function (): void {
    $property = new Property;

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatMinRentalPeriod');

    expect($method->invoke($service, $property))->toBe('');
});

it('formats address by concatenating address fields', function (): void {
    $property = new Property([
        'cim_irsz' => '1051',
        'cim_varos' => 'Budapest',
        'cim_utca' => 'Vaci',
        'cim_utca_addons' => 'utca',
        'cim_hazszam' => '10',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatAddress');

    expect($method->invoke($service, $property))->toBe('1051 Budapest, Vaci utca 10');
});

it('formats address with missing fields gracefully', function (): void {
    $property = new Property([
        'cim_irsz' => '1051',
        'cim_varos' => 'Budapest',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatAddress');

    expect($method->invoke($service, $property))->toBe('1051 Budapest,');
});

it('generates a valid Excel spreadsheet with correct structure', function (): void {
    $property = new Property([
        'title' => 'Test Building',
        'cim_irsz' => '1051',
        'cim_varos' => 'Budapest',
        'cim_utca' => 'Vaci',
        'cim_utca_addons' => 'utca',
        'cim_hazszam' => '10',
        'construction_year' => '2018',
        'min_berleti_dij' => '12',
        'max_berleti_dij' => '15',
        'min_berleti_dij_addons' => 'EUR/m2/ho',
        'uzemeletetesi_dij' => '3.5',
        'uzemeletetesi_dij_addons' => 'EUR/m2/ho',
        'kozos_teruleti_arany' => '10',
        'kozos_teruleti_arany_addons' => '%',
        'min_parkolas_dija' => '100',
        'max_parkolas_dija' => '150',
        'min_parkolas_dija_addons' => 'EUR/hely/ho',
        'min_berleti_idoszak' => '5',
        'min_berleti_idoszak_addons' => 'ev',
    ]);

    $service = new FavoritesExcelExportService;
    $response = $service->generate(collect([$property]));

    // Capture the streamed response into a temp file
    $tempFile = tempnam(sys_get_temp_dir(), 'excel_test_');
    ob_start();
    $response->sendContent();
    $content = ob_get_clean();
    file_put_contents($tempFile, $content);

    // Read the file back
    $reader = new XlsxReader;
    $spreadsheet = $reader->load($tempFile);
    $sheet = $spreadsheet->getActiveSheet();

    // Verify sheet name
    expect($sheet->getTitle())->toBe('munkafuzet');

    // Verify title row
    expect($sheet->getCell('B1')->getValue())->toBe('PSG-IRODAHAZAK.HU');

    // Verify header row
    expect($sheet->getCell('A3')->getValue())->toBe('Irodahaz neve');
    expect($sheet->getCell('B3')->getValue())->toBe('Irodahaz cime');
    expect($sheet->getCell('C3')->getValue())->toBe('Epites eve');
    expect($sheet->getCell('D3')->getValue())->toBe('Berleti dij');
    expect($sheet->getCell('E3')->getValue())->toBe('Uzemeltetesi dij');
    expect($sheet->getCell('F3')->getValue())->toBe('Kozos teruleti arany');
    expect($sheet->getCell('G3')->getValue())->toBe('Parkolohely dija');
    expect($sheet->getCell('H3')->getValue())->toBe('Min. berleti idoszak');
    expect($sheet->getCell('I3')->getValue())->toBe('Ajanlott terulet');

    // Verify data row
    expect($sheet->getCell('A4')->getValue())->toBe('Test Building');
    expect($sheet->getCell('B4')->getValue())->toBe('1051 Budapest, Vaci utca 10');
    expect((string) $sheet->getCell('C4')->getValue())->toBe('2018');
    expect($sheet->getCell('D4')->getValue())->toBe('12 - 15 EUR/m2/ho');
    expect($sheet->getCell('E4')->getValue())->toBe('3.5 EUR/m2/ho');
    expect($sheet->getCell('F4')->getValue())->toBe('10 %');
    expect($sheet->getCell('G4')->getValue())->toBe('100 - 150 EUR/hely/ho');
    expect($sheet->getCell('H4')->getValue())->toBe('5 ev');
    expect($sheet->getCell('I4')->getValue())->toBeNull();

    // Verify header row is bold
    expect($sheet->getStyle('A3')->getFont()->getBold())->toBeTrue();

    // Verify title is bold
    expect($sheet->getStyle('B1')->getFont()->getBold())->toBeTrue();

    // Clean up
    unlink($tempFile);
});

it('generates an Excel file with multiple properties', function (): void {
    $properties = collect([
        new Property([
            'title' => 'Building A',
            'cim_irsz' => '1051',
            'cim_varos' => 'Budapest',
            'cim_utca' => 'Vaci',
            'cim_utca_addons' => 'utca',
            'cim_hazszam' => '1',
            'construction_year' => '2015',
            'min_berleti_dij' => '10',
            'max_berleti_dij' => '10',
            'min_berleti_dij_addons' => 'EUR/m2/ho',
        ]),
        new Property([
            'title' => 'Building B',
            'cim_irsz' => '1061',
            'cim_varos' => 'Budapest',
            'cim_utca' => 'Andrassy',
            'cim_utca_addons' => 'ut',
            'cim_hazszam' => '5',
            'construction_year' => '2020',
            'min_berleti_dij' => '15',
            'max_berleti_dij' => '20',
            'min_berleti_dij_addons' => 'EUR/m2/ho',
        ]),
    ]);

    $service = new FavoritesExcelExportService;
    $response = $service->generate($properties);

    $tempFile = tempnam(sys_get_temp_dir(), 'excel_test_');
    ob_start();
    $response->sendContent();
    $content = ob_get_clean();
    file_put_contents($tempFile, $content);

    $reader = new XlsxReader;
    $spreadsheet = $reader->load($tempFile);
    $sheet = $spreadsheet->getActiveSheet();

    // Verify first property in row 4
    expect($sheet->getCell('A4')->getValue())->toBe('Building A');
    expect($sheet->getCell('D4')->getValue())->toBe('10 EUR/m2/ho');

    // Verify second property in row 5
    expect($sheet->getCell('A5')->getValue())->toBe('Building B');
    expect($sheet->getCell('D5')->getValue())->toBe('15 - 20 EUR/m2/ho');

    // Row 6 should be empty (no third property)
    expect($sheet->getCell('A6')->getValue())->toBeNull();

    unlink($tempFile);
});

it('generates an empty Excel file with only headers when no properties provided', function (): void {
    $service = new FavoritesExcelExportService;
    $response = $service->generate(collect());

    $tempFile = tempnam(sys_get_temp_dir(), 'excel_test_');
    ob_start();
    $response->sendContent();
    $content = ob_get_clean();
    file_put_contents($tempFile, $content);

    $reader = new XlsxReader;
    $spreadsheet = $reader->load($tempFile);
    $sheet = $spreadsheet->getActiveSheet();

    // Headers should still be present
    expect($sheet->getCell('A3')->getValue())->toBe('Irodahaz neve');
    expect($sheet->getCell('B1')->getValue())->toBe('PSG-IRODAHAZAK.HU');

    // No data rows
    expect($sheet->getCell('A4')->getValue())->toBeNull();

    unlink($tempFile);
});

it('returns a streamed response with correct headers', function (): void {
    $service = new FavoritesExcelExportService;
    $response = $service->generate(collect());

    expect($response->getStatusCode())->toBe(200);
    expect($response->headers->get('Content-Type'))
        ->toBe('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    expect($response->headers->get('Content-Disposition'))
        ->toContain('PSG_IRODA_ajanlatok_')
        ->toContain('.xlsx');
    expect($response->headers->get('Cache-Control'))
        ->toContain('no-cache');
});
