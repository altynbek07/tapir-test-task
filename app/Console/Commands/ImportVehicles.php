<?php

namespace App\Console\Commands;

use App\Services\Importers\NewVehiclesImporter;
use App\Services\Importers\UsedVehiclesImporter;
use Illuminate\Console\Command;

class ImportVehicles extends Command
{
    protected $signature = 'vehicles:import {--type=all : Type of vehicles to import (all/new/used)}';
    protected $description = 'Import vehicles from external sources';

    public function handle(
        NewVehiclesImporter $newVehiclesImporter,
        UsedVehiclesImporter $usedVehiclesImporter
    ): int {
        $type = $this->option('type');

        try {
            $this->info('Starting vehicles import...');

            if ($type === 'all' || $type === 'new') {
                $this->info('Importing new vehicles...');
                $newVehiclesImporter->import();
            }

            if ($type === 'all' || $type === 'used') {
                $this->info('Importing used vehicles...');
                $usedVehiclesImporter->import();
            }

            $this->info('Import completed successfully!');
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Import failed: {$e->getMessage()}");
            return self::FAILURE;
        }
    }
}
