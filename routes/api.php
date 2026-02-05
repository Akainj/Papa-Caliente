<?php

use App\Http\Controllers\PapaCalienteController;
use Illuminate\Support\Facades\Route;

Route::post('/iniciar', [PapaCalienteController::class, 'iniciar']);

Route::post('/recibir', [PapaCalienteController::class, 'recibir'])
    ->middleware('delay');

Route::get('/estado', [PapaCalienteController::class, 'estado']);
