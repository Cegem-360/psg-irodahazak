<?php

declare(strict_types=1);

use App\Models\Property;
use App\Services\FavoritesExcelExportService;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

it('formats rental fee as single value when min and max are the same', function (): void {
    $property = new Property([
        'min_rent' => '12',
        'max_rent' => '12',
        'min_rent_unit' => 'EUR/m2/ho',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatRentalFee');

    expect($method->invoke($service, $property))->toBe('12 EUR/m2/ho');
});

it('formats rental fee as range when min and max differ', function (): void {
    $property = new Property([
        'min_rent' => '10',
        'max_rent' => '15',
        'min_rent_unit' => 'EUR/m2/ho',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatRentalFee');

    expect($method->invoke($service, $property))->toBe('10 - 15 EUR/m2/ho');
});

it('formats rental fee without addons', function (): void {
    $property = new Property([
        'min_rent' => '10',
        'max_rent' => '15',
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
        'operating_fee' => '3.5',
        'operating_fee_unit' => 'EUR/m2/ho',
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
        'common_area_ratio' => '10',
        'common_area_ratio_unit' => '%',
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
        'min_parking_fee' => '100',
        'max_parking_fee' => '150',
        'min_parking_fee_unit' => 'EUR/hely/ho',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatParkingFee');

    expect($method->invoke($service, $property))->toBe('100 - 150 EUR/hely/ho');
});

it('formats parking fee as single value when min and max are the same', function (): void {
    $property = new Property([
        'min_parking_fee' => '120',
        'max_parking_fee' => '120',
        'min_parking_fee_unit' => 'EUR/hely/ho',
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
        'min_lease_term' => '5',
        'min_lease_term_unit' => 'ev',
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
        'postal_code' => '1051',
        'city' => 'Budapest',
        'street' => 'Vaci',
        'street_type' => 'utca',
        'house_number' => '10',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatAddress');

    expect($method->invoke($service, $property))->toBe('1051 Budapest, Vaci utca 10');
});

it('formats address with missing fields gracefully', function (): void {
    $property = new Property([
        'postal_code' => '1051',
        'city' => 'Budapest',
    ]);

    $service = new FavoritesExcelExportService;
    $reflection = new ReflectionClass($service);
    $method = $reflection->getMethod('formatAddress');

    expect($method->invoke($service, $property))->toBe('1051 Budapest,');
});

it('generates a valid Excel spreadsheet with correct structure', function (): void {
    $property = new Property([
        'title' => 'Test Building',
        'postal_code' => '1051',
        'city' => 'Budapest',
        'street' => 'Vaci',
        'street_type' => 'utca',
        'house_number' => '10',
        'construction_year' => '2018',
        'min_rent' => '12',
        'max_rent' => '15',
        'min_rent_unit' => 'EUR/m2/ho',
        'operating_fee' => '3.5',
        'operating_fee_unit' => 'EUR/m2/ho',
        'common_area_ratio' => '10',
        'common_area_ratio_unit' => '%',
        'min_parking_fee' => '100',
        'max_parking_fee' => '150',
        'min_parking_fee_unit' => 'EUR/hely/ho',
        'min_lease_term' => '5',
        'min_lease_term_unit' => 'ev',
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
    expect($sheet->getCell('A3')->getValue())->toBe('Irodaház neve');
    expect($sheet->getCell('B3')->getValue())->toBe('Irodaház címe');
    expect($sheet->getCell('C3')->getValue())->toBe('Építés éve');
    expect($sheet->getCell('D3')->getValue())->toBe('Bérleti díj');
    expect($sheet->getCell('E3')->getValue())->toBe('Üzemeltetési díj');
    expect($sheet->getCell('F3')->getValue())->toBe('Közös területi arány');
    expect($sheet->getCell('G3')->getValue())->toBe('Parkolóhely díja');
    expect($sheet->getCell('H3')->getValue())->toBe('Min. bérleti időszak');
    expect($sheet->getCell('I3')->getValue())->toBe('Ajánlott terület');

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
    File::delete($tempFile);
});

it('generates an Excel file with multiple properties', function (): void {
    $properties = collect([
        new Property([
            'title' => 'Building A',
            'postal_code' => '1051',
            'city' => 'Budapest',
            'street' => 'Vaci',
            'street_type' => 'utca',
            'house_number' => '1',
            'construction_year' => '2015',
            'min_rent' => '10',
            'max_rent' => '10',
            'min_rent_unit' => 'EUR/m2/ho',
        ]),
        new Property([
            'title' => 'Building B',
            'postal_code' => '1061',
            'city' => 'Budapest',
            'street' => 'Andrassy',
            'street_type' => 'ut',
            'house_number' => '5',
            'construction_year' => '2020',
            'min_rent' => '15',
            'max_rent' => '20',
            'min_rent_unit' => 'EUR/m2/ho',
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

    File::delete($tempFile);
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
    expect($sheet->getCell('A3')->getValue())->toBe('Irodaház neve');
    expect($sheet->getCell('B1')->getValue())->toBe('PSG-IRODAHAZAK.HU');

    // No data rows
    expect($sheet->getCell('A4')->getValue())->toBeNull();

    File::delete($tempFile);
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
