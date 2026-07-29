@extends('layouts.app')

@section('title', 'Invitación no disponible')

@section('content')

<div class="text-center">

    <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-red-100">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-10 w-10 text-red-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />

        </svg>
    </div>

    <h1 class="text-3xl font-bold text-gray-900">
        La invitación ya no es válida
    </h1>

    <p class="mt-4 text-gray-600">
        Esta invitación fue utilizada anteriormente o ya venció.
    </p>

    <p class="mt-2 text-gray-600">
        Si necesitás acceder nuevamente a la iglesia, solicitale al administrador que genere una nueva invitación.
    </p>

    <div class="mt-8">
        <a href="/"
            class="inline-flex rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white shadow hover:bg-indigo-700 transition">
            Ir al inicio
        </a>
    </div>

</div>

@endsection
