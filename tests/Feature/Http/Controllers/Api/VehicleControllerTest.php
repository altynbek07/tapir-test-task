<?php

use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it returns paginated vehicles', function () {
    Vehicle::factory()->count(20)->create();

    $response = $this->getJson('/api/stock');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'brand',
                    'model',
                    'vin',
                    'price',
                    'year',
                    'mileage',
                    'type',
                ],
            ],
            'links',
            'meta',
        ])
        ->assertJsonCount(15, 'data'); // default pagination
});

test('it filters by brand', function () {
    Vehicle::factory()->create(['brand' => 'BMW']);
    Vehicle::factory()->create(['brand' => 'Audi']);

    $response = $this->getJson('/api/stock?brand=BMW');

    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.brand', 'BMW');
});

test('it filters by price range', function () {
    Vehicle::factory()->create(['price' => 10000]);
    Vehicle::factory()->create(['price' => 20000]);
    Vehicle::factory()->create(['price' => 30000]);

    $response = $this->getJson('/api/stock?price_more=15000&price_less=25000');

    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.price', 20000);
});

test('it filters by year range', function () {
    Vehicle::factory()->create(['year' => 2018]);
    Vehicle::factory()->create(['year' => 2019]);
    Vehicle::factory()->create(['year' => 2020]);

    $response = $this->getJson('/api/stock?year_from=2019&year_to=2019');

    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.year', 2019);
});

test('it validates input', function () {
    $response = $this->getJson('/api/stock?year_from=invalid');

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['year_from']);
});

dataset('filters', [
    'by brand' => [
        'filter' => ['brand' => 'BMW'],
        'matches' => ['brand' => 'BMW'],
        'nonMatches' => ['brand' => 'Audi'],
    ],
    'by price range' => [
        'filter' => ['price_more' => 15000, 'price_less' => 25000],
        'matches' => ['price' => 20000],
        'nonMatches' => ['price' => 30000],
    ],
    'by year range' => [
        'filter' => ['year_from' => 2019, 'year_to' => 2019],
        'matches' => ['year' => 2019],
        'nonMatches' => ['year' => 2020],
    ],
]);

test('it filters vehicles correctly', function (array $filter, array $matches, array $nonMatches) {
    Vehicle::factory()->create($matches);
    Vehicle::factory()->create($nonMatches);

    $response = $this->getJson('/api/stock?'.http_build_query($filter));

    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.'.array_key_first($matches), $matches[array_key_first($matches)]);
})->with('filters');
