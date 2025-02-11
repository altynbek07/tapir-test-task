<?php

namespace App\Services\Importers;

class NewVehiclesImporter extends AbstractVehicleImporter
{
    protected function getSourceUrl(): string
    {
        return config('importers.sources.new_vehicles.url');
    }

    protected function getVehicleType(): string
    {
        return 'new';
    }
}
