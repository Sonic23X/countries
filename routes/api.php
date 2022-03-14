<?php

use App\Http\Controllers\Api\CountryController;
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

Route::post('access', [CountryController::class, 'auth']);
Route::post('new', [CountryController::class, 'new']);
Route::put('update/{code}', [CountryController::class, 'update']);
Route::delete('delete/{code}', [CountryController::class, 'destroy']);
Route::get('csv', [CountryController::class, 'csv']);
