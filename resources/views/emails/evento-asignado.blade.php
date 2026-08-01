Hola {{ $asignacion->servidor->nombre }}

Fuiste asignado al evento:

{{ $asignacion->evento->nombre }}

Rol:
{{ $asignacion->eventoRol->rolServicio->nombre }}

Fecha:
{{ $asignacion->evento->fecha }}

Estado:
{{ $asignacion->estado }}

Ingresá a Coordina para confirmar tu asistencia.