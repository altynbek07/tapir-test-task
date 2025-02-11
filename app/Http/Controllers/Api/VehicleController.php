<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleFilterRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Services\QueryBuilders\VehicleQueryBuilder;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleController extends Controller
{
    public function index(VehicleFilterRequest $request): ResourceCollection
    {
        $query = Vehicle::query();

        $vehicles = VehicleQueryBuilder::fromRequest($query, $request)
            ->paginate(
                perPage: $request->get('per_page', 15)
            );

        return VehicleResource::collection($vehicles);
    }
}
