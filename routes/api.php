<?php

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

//Route::apiResource('/registro', App\Http\Controllers\RegistroController::class);

Route::post('/evento', [App\Http\Controllers\RegistroController::class, 'evento']);
Route::get('/balance/{id}', [App\Http\Controllers\RegistroController::class, 'balance']);
Route::post('/reset', [App\Http\Controllers\RegistroController::class, 'reset']);
Route::post('/nuevaCuenta', [App\Http\Controllers\RegistroController::class, 'nuevaCuenta']);