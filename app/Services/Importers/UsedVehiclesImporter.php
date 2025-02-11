<?php

namespace App\Services\Importers;

class UsedVehiclesImporter extends AbstractVehicleImporter
{
    protected function getSourceUrl(): string
    {
        return config('importers.sources.used_vehicles.url');
    }

    protected function getVehicleType(): string
    {
        return 'used';
    }
}
