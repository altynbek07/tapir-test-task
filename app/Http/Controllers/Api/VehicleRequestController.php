<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequestRequest;
use App\Models\Vehicle;
use App\Services\VehicleRequestService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VehicleRequestController extends Controller
{
    public function __construct(
        private readonly VehicleRequestService $service
    ) {}

    public function store(CreateVehicleRequestRequest $request): JsonResponse
    {
        $vehicle = Vehicle::findOrFail($request->validated('vehicle_id'));

        $vehicleRequest = $this->service->createRequest(
            vehicle: $vehicle,
            phone: $request->validated('phone')
        );

        return response()->json([
            'message' => 'Request created successfully',
            'id' => $vehicleRequest->id,
        ], Response::HTTP_CREATED);
    }
}
