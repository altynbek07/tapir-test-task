<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'model' => $this->model,
            'vin' => $this->vin,
            'price' => $this->price,
            'year' => $this->year,
            'mileage' => $this->mileage,
            'type' => $this->type,
        ];
    }
}
