<?php

use App\Services\Importers\NewVehiclesImporter;
use App\Services\Importers\UsedVehiclesImporter;

beforeEach(function () {
    $this->newVehiclesImporter = Mockery::mock(NewVehiclesImporter::class);
    $this->usedVehiclesImporter = Mockery::mock(UsedVehiclesImporter::class);

    $this->app->instance(NewVehiclesImporter::class, $this->newVehiclesImporter);
    $this->app->instance(UsedVehiclesImporter::class, $this->usedVehiclesImporter);
});

test('it imports all vehicles', function () {
    $this->newVehiclesImporter->shouldReceive('import')->once();
    $this->usedVehiclesImporter->shouldReceive('import')->once();

    $response = $this->getJson('/api/import');

    $response->assertOk()
        ->assertJson(['message' => 'Import completed successfully']);
});

test('it imports only new vehicles', function () {
    $this->newVehiclesImporter->shouldReceive('import')->once();
    $this->usedVehiclesImporter->shouldNotReceive('import');

    $response = $this->getJson('/api/import?type=new');

    $response->assertOk();
});

test('it imports only used vehicles', function () {
    $this->newVehiclesImporter->shouldNotReceive('import');
    $this->usedVehiclesImporter->shouldReceive('import')->once();

    $response = $this->getJson('/api/import?type=used');

    $response->assertOk();
});
