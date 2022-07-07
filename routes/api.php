<?php

use App\Http\Controllers\API\PlantController;
use App\Http\Controllers\API\GenusController;
use App\Http\Controllers\API\FamilyController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('plants', PlantController::class);
Route::apiResource('genuses', GenusController::class);
Route::apiResource('families', FamilyController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('countries', CountryController::class);
