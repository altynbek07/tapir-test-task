<?php

use App\Http\Requests\VehicleFilterRequest;
use App\Models\Vehicle;
use App\Services\QueryBuilders\VehicleQueryBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it filters by brand', function () {
    Vehicle::factory()->create(['brand' => 'BMW']);
    Vehicle::factory()->create(['brand' => 'Audi']);

    $query = Vehicle::query();
    $builder = new VehicleQueryBuilder($query);

    $result = $builder->filterByBrand('BMW')->getQuery()->get();

    expect($result)->toHaveCount(1)
        ->and($result->first()->brand)->toBe('BMW');
});

test('it filters by price range', function () {
    Vehicle::factory()->create(['price' => 10000]);
    Vehicle::factory()->create(['price' => 20000]);
    Vehicle::factory()->create(['price' => 30000]);

    $query = Vehicle::query();
    $builder = new VehicleQueryBuilder($query);

    $result = $builder
        ->filterByPriceRange(15000, 25000)
        ->getQuery()
        ->get();

    expect($result)->toHaveCount(1)
        ->and($result->first()->price)->toBe(20000);
});

test('it filters by zero price', function () {
    Vehicle::factory()->create(['price' => 0]);
    Vehicle::factory()->create(['price' => 10000]);

    $query = Vehicle::query();
    $builder = new VehicleQueryBuilder($query);

    $result = $builder
        ->filterByPriceRange(0, 5000)
        ->getQuery()
        ->get();

    expect($result)->toHaveCount(1)
        ->and($result->first()->price)->toBe(0);
});

test('it builds from request', function () {
    Vehicle::factory()->create([
        'brand' => 'BMW',
        'price' => 20000,
        'year' => 2019,
    ]);
    Vehicle::factory()->create([
        'brand' => 'Audi',
        'price' => 30000,
        'year' => 2020,
    ]);

    $request = new VehicleFilterRequest([
        'brand' => 'BMW',
        'year_from' => 2019,
        'year_to' => 2019,
    ]);

    $query = Vehicle::query();
    $result = VehicleQueryBuilder::fromRequest($query, $request)->get();

    expect($result)->toHaveCount(1)
        ->and($result->first()->brand)->toBe('BMW')
        ->and($result->first()->year)->toBe(2019);
});
