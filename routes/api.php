<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\CommandController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('devices', [DeviceController::class, 'index']);
    Route::get('devices/{id}', [DeviceController::class, 'show']);
    Route::post('devices', [DeviceController::class, 'store']);
    Route::put('devices/{id}', [DeviceController::class, 'update']);
    Route::delete('devices/{id}', [DeviceController::class, 'destroy']);
    Route::post('devices/select', [DeviceController::class, 'selectDevice']);
    Route::get('user/{userId}/devices', [DeviceController::class, 'getUserDevices']);

    Route::get('devices/{deviceId}/commands', [CommandController::class, 'index']);
    Route::get('devices/{deviceId}/commands/{commandId}', [CommandController::class, 'show']);
    Route::post('devices/{deviceId}/commands', [CommandController::class, 'store']);
    Route::put('devices/{deviceId}/commands/{commandId}', [CommandController::class, 'update']);
    Route::delete('devices/{deviceId}/commands/{commandId}', [CommandController::class, 'destroy']);
});
