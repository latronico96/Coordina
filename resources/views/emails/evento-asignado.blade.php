@extends('layouts.mail')

@section('content')

<h2>
    Nueva asignación de servicio
</h2>


<p>
    Hola {{ $asignacion->servidor->nombre }}.
</p>


<p>
    Fuiste asignado para colaborar en el siguiente evento:
</p>


<h3>
    {{ $asignacion->evento->nombre }}
</h3>


<p>
    <strong>Rol:</strong><br>
    {{ $asignacion->eventoRol->rolServicio->nombre }}
</p>


<p>
    <strong>Fecha:</strong><br>
    {{ $asignacion->evento->fecha->format('d/m/Y') }}
</p>


<p>
    <strong>Horario:</strong><br>
    {{ $asignacion->evento->hora_inicio }}
</p>


<p>
    Por favor confirmá tu asistencia:
</p>


<p style="margin:30px 0">

<a href="{{ $url }}"
style="
background:#16a34a;
color:white;
padding:12px 25px;
border-radius:6px;
text-decoration:none;
font-weight:bold;
">
Confirmar asistencia
</a>

</p>


<p>
    Si no podés asistir también podés indicarlo desde el enlace.
</p>


<p>
    El enlace vence el:
    <strong>
        {{ $token->expires_at->format('d/m/Y H:i') }}
    </strong>
</p>


@endsection
