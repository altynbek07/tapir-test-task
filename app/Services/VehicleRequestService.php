<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Models\VehicleRequest;

class VehicleRequestService
{
    public function createRequest(Vehicle $vehicle, string $phone): VehicleRequest
    {
        $request = VehicleRequest::create([
            'vehicle_id' => $vehicle->id,
            'phone' => $phone,
        ]);

        return $request;
    }
}
