<?php

use App\Http\Controllers\InvitacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invitacion/{token}', [InvitacionController::class, 'mostrar'])
    ->name('invitacion.aceptar');

Route::post('/invitacion/{token}', [InvitacionController::class, 'aceptar'])
    ->name('invitacion.confirmar');
