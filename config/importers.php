<?php

return [
    'sources' => [
        'new_vehicles' => [
            'url' => env('NEW_VEHICLES_SOURCE_URL', 'https://tapir.ws/files/new_cars.json'),
        ],
        'used_vehicles' => [
            'url' => env('USED_VEHICLES_SOURCE_URL', 'https://tapir.ws/files/used_cars.xml'),
        ],
    ],
];
