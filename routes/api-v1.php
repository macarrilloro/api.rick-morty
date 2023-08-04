<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CharacterController;
use App\Http\Controllers\Api\EpisodeController;
use App\Http\Controllers\Api\Auth\LoginController;

Route::post('register', [RegisterController::class, 'store'])->name('api.v1.register');

// Route::get('locations', [LocationController::class, 'index'])->name('api.v1.locations.index');
// Route::post('locations', [LocationController::class, 'store'])->name('api.v1.locations.store');
// Route::get('locations/{location}', [LocationController::class, 'show'])->name('api.v1.locations.show');
// Route::put('locations/{location}', [LocationController::class, 'update'])->name('api.v1.locations.update');
// Route::delete('locations/{location}', [LocationController::class, 'delete'])->name('api.v1.locations.delete');

Route::apiResource('locations', LocationController::class)->names('api.v1.locations');
Route::apiResource('characters', CharacterController::class)->names('api.v1.characters');
Route::apiResource('episodes', EpisodeController::class)->names('api.v1.episodes');
Route::apiResource('origins', EpisodeController::class)->names('api.v1.origins');
Route::post('login',[LoginController::class, 'store']);