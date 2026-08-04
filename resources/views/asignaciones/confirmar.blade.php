@extends('layouts.app')

@section('title', 'Confirmar asistencia')

@section('content')

<div class="max-w-xl mx-auto rounded-lg bg-white p-8 shadow">

    <div class="mb-6 text-center">

        <h1 class="text-3xl font-bold text-gray-900">
            Confirmar asistencia
        </h1>

        <p class="mt-2 text-gray-600">
            Te asignaron al siguiente evento:
        </p>

    </div>

    <div class="mb-8 rounded-lg bg-gray-50 p-4 space-y-2">

        <div class="flex justify-between">
            <span class="text-gray-500">Evento</span>
            <span class="font-medium">{{ $asignacion->evento->nombre }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Fecha</span>
            <span>{{ $asignacion->evento->fecha->format('d/m/Y') }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Hora</span>
            <span>{{ $asignacion->evento->hora_inicio }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Rol</span>
            <span>{{ $asignacion->eventoRol->rolServicio->nombre }}</span>
        </div>

    </div>

    <div class="flex justify-center gap-4">

        <form method="POST"
              action="{{ route('asignaciones.confirmar', $token) }}">
            @csrf

            <button
                class="rounded-lg bg-green-600 px-6 py-3 font-semibold text-white hover:bg-green-700 transition">
                Confirmar asistencia
            </button>

        </form>

        <form method="POST"
              action="{{ route('asignaciones.rechazar', $token) }}">
            @csrf

            <button
                class="rounded-lg bg-red-600 px-6 py-3 font-semibold text-white hover:bg-red-700 transition">
                No podré asistir
            </button>

        </form>

    </div>

</div>

@endsection
