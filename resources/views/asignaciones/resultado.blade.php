@extends('layouts.app')

@section('title', $titulo)

@section('content')

<div class="mx-auto max-w-xl rounded-lg bg-white p-8 shadow">

    <div class="mb-6 text-center">

        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8 text-green-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7" />

            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900">
            {{ $titulo }}
        </h1>

        <p class="mt-4 text-gray-600">
            {{ $mensaje }}
        </p>

    </div>

    <div class="mt-8 text-center">

        <a href="/admin"
           class="inline-flex rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white shadow hover:bg-indigo-700 transition">
            Cerrar
        </a>

    </div>

</div>

@endsection
