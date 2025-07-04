<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\controllers\PublicidadeController;
use App\Http\controllers\EstadoController;

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

Route::apiResource('publicidade', PublicidadeController::class);

Route::apiResource('estado', PublicidadeController::class);

Route::post('/publicidades/{id}/estados', [PublicidadeController::class, 'vincularEstados']);