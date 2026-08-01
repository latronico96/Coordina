@extends('layouts.app')

@section('title', 'Cuenta activada')

@section('content')

<div class="text-center">

    <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-green-100">

        <svg xmlns="http://www.w3.org/2000/svg"
            class="h-10 w-10 text-green-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7" />

        </svg>

    </div>


    <h1 class="text-3xl font-bold text-gray-900">
        Cuenta activada
    </h1>


    <p class="mt-4 text-gray-600">
        Tu cuenta fue creada correctamente.
    </p>


    <p class="mt-2 text-gray-600">
        Ya podés ingresar al sistema.
    </p>


    <div class="mt-8">

        <a href="{{ route('login') }}"
            class="inline-flex rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white shadow hover:bg-indigo-700 transition">

            Iniciar sesión

        </a>

    </div>

</div>

@endsection
