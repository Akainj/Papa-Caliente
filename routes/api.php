<?php

use App\Http\Controllers\PapaCalienteController;

Route::post('/recibir', [PapaCalienteController::class, 'recibir'])
    ->middleware('delay');

Route::get('/estado', [PapaCalienteController::class, 'estado']);
