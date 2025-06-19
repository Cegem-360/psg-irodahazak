<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class OfficeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $offices = Property::query()
            ->select('id', 'title', 'cim_varos')
            ->rent()
            ->active()
            ->when($request->district, function ($query) use ($request): void {
                $query->where(function ($q) use ($request) {
                    $q->where('cim_varos', 'like', '%'.$request->district.'.%')
                        ->orWhere('cim_varos', 'like', '%'.$request->district.' %')
                        ->orWhere('cim_varos', 'like', '%'.$request->district.'%');
                });
            })
            ->orderBy('title')
            ->get()
            ->map(function ($office) {
                // Extract district from address
                $district = $this->extractDistrict($office->cim_varos);

                return [
                    'id' => $office->id,
                    'title' => $office->title,
                    'district' => $district,
                ];
            });

        return response()->json($offices);
    }

    private function extractDistrict(string $address): string
    {
        // Extract Roman numerals from address
        if (preg_match('/(\b[IVX]+)\.\s*ker/', $address, $matches)) {
            return $matches[1];
        }

        // Fallback patterns
        if (preg_match('/(\d+)\.\s*ker/', $address, $matches)) {
            return $this->convertToRoman((int) $matches[1]);
        }

        return '';
    }

    private function convertToRoman(int $number): string
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII', 13 => 'XIII', 14 => 'XIV', 15 => 'XV',
            16 => 'XVI', 17 => 'XVII', 18 => 'XVIII', 19 => 'XIX', 20 => 'XX',
            21 => 'XXI', 22 => 'XXII', 23 => 'XXIII',
        ];

        return $romans[$number] ?? '';
    }
}
