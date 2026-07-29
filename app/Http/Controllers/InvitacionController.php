<?php

namespace App\Http\Controllers;

use App\Services\InvitacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InvitacionController extends Controller
{
    public function mostrar(
        string $token,
        InvitacionService $service
    ) {
        $invitacion = $service->buscarPorToken($token);

        if (! $invitacion) {
            abort(404);
        }

        if (! $service->valida($invitacion)) {
            return view('invitaciones.expirada');
        }

        return view('invitaciones.aceptar', [
            'invitacion' => $invitacion,
        ]);
    }

    public function aceptar(
        Request $request,
        string $token,
        InvitacionService $service
    ) {

        $invitacion = $service->buscarPorToken($token);

        if (! $invitacion || ! $service->valida($invitacion)) {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $usuario = $invitacion->user;

        $usuario->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'activated_at' => now(),
        ]);

        $service->aceptar($invitacion);

        return redirect('/admin/login')
            ->with('success', 'Cuenta activada correctamente');
    }
}
