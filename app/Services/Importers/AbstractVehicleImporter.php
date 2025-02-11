<?php

namespace App\Services\Importers;

use App\Contracts\VehicleImporter;
use App\DataTransferObjects\VehicleDto;
use App\Models\Vehicle;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

abstract class AbstractVehicleImporter implements VehicleImporter
{
    abstract protected function getSourceUrl(): string;
    abstract protected function getVehicleType(): string;

    public function import(): void
    {
        try {
            $response = Http::get($this->getSourceUrl());

            if (!$response->successful()) {
                throw new \RuntimeException(
                    "Failed to fetch vehicles data: {$response->status()}"
                );
            }

            $vehicles = $this->parseResponse($response);

            foreach ($vehicles as $vehicleDto) {
                $this->importVehicle($vehicleDto);
            }
        } catch (\Exception $e) {
            Log::error("Error importing vehicles: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * @return VehicleDto[]
     */
    protected function parseResponse(Response $response): array
    {
        $contentType = $response->header('Content-Type');

        $data = match (true) {
            str_contains($contentType, 'application/json') => $response->json(),
            str_contains($contentType, 'application/xml'),
            str_contains($contentType, 'text/xml') => $this->parseXml($response->body()),
            default => throw new \RuntimeException("Unsupported content type: {$contentType}")
        };

        return array_map(
            fn(array $item) => VehicleDto::fromArray($item),
            $data
        );
    }

    protected function parseXml(string $content): array
    {
        $xml = new SimpleXMLElement($content);
        $result = [];

        foreach ($xml->vehicle as $vehicle) {
            $result[] = [
                'brand' => (string)$vehicle->brand,
                'model' => (string)$vehicle->model,
                'vin' => (string)$vehicle->vin,
                'price' => (int)$vehicle->price,
                'year' => isset($vehicle->year) ? (int)$vehicle->year : null,
                'mileage' => isset($vehicle->mileage) ? (int)$vehicle->mileage : null,
            ];
        }

        return $result;
    }

    protected function importVehicle(VehicleDto $vehicleDto): void
    {
        Vehicle::updateOrCreate(
            ['vin' => $vehicleDto->vin],
            [
                ...$vehicleDto->toArray(),
                'type' => $this->getVehicleType()
            ]
        );
    }
}
