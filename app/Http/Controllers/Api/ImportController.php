<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Importers\NewVehiclesImporter;
use App\Services\Importers\UsedVehiclesImporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function __construct(
        private readonly NewVehiclesImporter $newVehiclesImporter,
        private readonly UsedVehiclesImporter $usedVehiclesImporter,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $type = $request->query('type', 'all');

            if ($type === 'all' || $type === 'new') {
                $this->newVehiclesImporter->import();
            }

            if ($type === 'all' || $type === 'used') {
                $this->usedVehiclesImporter->import();
            }

            return response()->json(['message' => 'Import completed successfully']);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Import failed: ' . $e->getMessage()],
                500
            );
        }
    }
}
