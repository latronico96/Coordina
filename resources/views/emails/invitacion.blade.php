@extends('layouts.mail')

@section('content')

<h2>Has sido invitado a Coordina</h2>

<p>
    Hola.
</p>

<p>
    Has recibido una invitación para formar parte del equipo de:
</p>

<p>
    <strong>
        {{ $invitacion->iglesia->nombre }}
    </strong>
</p>


<p>
    Tu rol asignado es:
</p>

<p>
    <strong>
        {{ $invitacion->rol->label() }}
    </strong>
</p>


<p>
    Esta invitación vence el:
</p>

<p>
    <strong>
        {{ $invitacion->token()->expires_at->format('d/m/Y H:i') }}
    </strong>
</p>


<p style="margin:30px 0">

<a href="{{ $url }}"
style="
background:#2563eb;
color:white;
padding:12px 25px;
border-radius:6px;
text-decoration:none;
font-weight:bold;
">
Aceptar invitación
</a>

</p>


<p>
    Si el botón no funciona, copiá este enlace:
</p>

<p>
    <a href="{{ $url }}">
        {{ $url }}
    </a>
</p>

@endsection