@extends('layouts.app')

@section('title', 'Activar cuenta')

@section('content')
<div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

    <div class="mb-6 text-center">

        <h1 class="text-3xl font-bold text-gray-900">
            Activar cuenta
        </h1>

        <p class="mt-2 text-gray-600">
            Fuiste invitado a participar en:
        </p>

        <p class="mt-2 text-lg font-semibold text-indigo-600">
            {{ $invitacion->iglesia->nombre }}
        </p>

    </div>


    <div class="mb-6 rounded-lg bg-gray-50 p-4 text-sm">

        <div class="flex justify-between mb-2">
            <span class="text-gray-500">
                Email
            </span>

            <span class="font-medium text-gray-800">
                {{ $invitacion->email }}
            </span>
        </div>


        <div class="flex justify-between">

            <span class="text-gray-500">
                Rol
            </span>

            <span class="font-medium text-gray-800">
                {{ $invitacion->rol->label() }}
            </span>

        </div>

    </div>


    <form method="POST"
        action="{{ route('invitacion.confirmar', ($invitacion->token()->token)) }}">

        @csrf


        <div class="space-y-5">


            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    autocomplete="Nombre invitacion"
                    required
                    class="w-full rounded-lg border-gray-300 px-4 py-3 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500">


                @error('name')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>



            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Contraseña
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-lg border-gray-300 px-4 py-3 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500">


                @error('password')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>



            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmar contraseña
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    required
                    class="w-full rounded-lg border-gray-300 px-4 py-3 text-base shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

            </div>



            <button
                type="submit"
                class="w-full rounded-lg bg-indigo-600 px-4 py-3 text-white font-semibold shadow hover:bg-indigo-700 transition">

                Activar cuenta

            </button>


        </div>


    </form>

</div>

@endsection
