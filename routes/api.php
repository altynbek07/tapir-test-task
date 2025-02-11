<?php

use App\Http\Controllers\Api\ImportController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\VehicleRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/import', ImportController::class);
Route::get('/stock', [VehicleController::class, 'index']);
Route::post('/requests', [VehicleRequestController::class, 'store']);
