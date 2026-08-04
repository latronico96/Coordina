<?php

use App\Http\Controllers\AsignacionConfirmacionController;
use App\Http\Controllers\InvitacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invitacion/{token}', [InvitacionController::class, 'mostrar'])
    ->name('invitacion.aceptar');

Route::post('/invitacion/{token}', [InvitacionController::class, 'aceptar'])
    ->name('invitacion.confirmar');

Route::get(
    '/asignaciones/{token}',
    [AsignacionConfirmacionController::class, 'mostrar']
)->name('asignaciones.mostrar');

Route::post(
    '/asignaciones/{token}/confirmar',
    [AsignacionConfirmacionController::class, 'confirmar']
)->name('asignaciones.confirmar');

Route::post(
    '/asignaciones/{token}/rechazar',
    [AsignacionConfirmacionController::class, 'rechazar']
)->name('asignaciones.rechazar');
