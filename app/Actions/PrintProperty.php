<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Property;
use App\Services\PropertyPdfService;
use Symfony\Component\HttpFoundation\Response;

/**
 * The printable PDF sheet of a property.
 */
final readonly class PrintProperty
{
    public function __construct(private PropertyPdfService $pdf) {}

    public function __invoke(Property $property): Response
    {
        return $this->pdf->generatePdfForView($property);
    }
}
