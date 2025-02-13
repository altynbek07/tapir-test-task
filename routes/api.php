<?php

use App\Http\Controllers\Api\ImportController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\VehicleRequestController;
use Illuminate\Support\Facades\Route;

Route::post('/import', ImportController::class);
Route::get('/stock', [VehicleController::class, 'index']);
Route::post('/requests', [VehicleRequestController::class, 'store']);
