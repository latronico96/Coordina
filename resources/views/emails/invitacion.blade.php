<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Invitación a Coordina</title>
</head>
<body>

    <h1>Has sido invitado a Coordina</h1>

    <p>Hola.</p>

    <p>Has recibido una invitación para unirte a la iglesia:</p>

    <p>
        <strong>{{ $invitacion->iglesia->nombre }}</strong>
    </p>

    <p>
        Rol asignado:
        <strong>{{ $invitacion->rol->label() }}</strong>
    </p>

    <p>
        Esta invitación vence el
        <strong>{{ $invitacion->expires_at->format('d/m/Y H:i') }}</strong>.
    </p>

    <p>
        <a href="{{ $url }}">
            Aceptar invitación
        </a>
    </p>

    <p>
        Si el botón no funciona, copia este enlace en tu navegador:
    </p>

    <p>{{ $url }}</p>

</body>
</html>
