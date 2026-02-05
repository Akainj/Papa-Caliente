<?php

use App\Http\Controllers\PapaCalienteController;

Route::post('/iniciar', [PapaCalienteController::class, 'iniciar']);
Route::post('/recibir', [PapaCalienteController::class, 'recibir'])
    ->middleware('delay');

Route::get('/estado', [PapaCalienteController::class, 'estado']);