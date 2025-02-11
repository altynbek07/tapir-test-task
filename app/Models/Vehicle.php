<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'vin',
        'price',
        'year',
        'mileage',
        'type',
    ];

    protected $casts = [
        'price' => 'integer',
        'year' => 'integer',
        'mileage' => 'integer',
    ];
}
