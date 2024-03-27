<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\FareController;
use App\Http\Controllers\Api\CallPriceSimulationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('plans')->group(function () {
    Route::get('/', [PlanController::class, 'getAll'])->name('plan::list');
});

Route::prefix('fares')->group(function () {
    Route::get('/', [FareController::class, 'getAll'])->name('fare::list');
});

Route::prefix('call-prices')->group(function () {
    Route::post('/simulate', [CallPriceSimulationController::class, 'simulate'])->name('call-price::simulate');
});
