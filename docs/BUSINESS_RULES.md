# Reglas de negocio

## Iglesias

* Cada instalación puede administrar múltiples iglesias.
* Toda la información pertenece a una única iglesia.
* Los datos nunca se comparten entre iglesias.

## Usuarios

* Un usuario representa una cuenta para acceder al sistema.
* Un usuario puede estar asociado a un servidor.
* Un servidor puede no tener usuario.
* Existen distintos perfiles de acceso (Administrador, Coordinador y Servidor).

## Servidores

* Un servidor pertenece a una iglesia.
* Un servidor puede tener múltiples roles.
* Un servidor puede participar en varios ministerios a través de sus roles.
* Un servidor puede registrar fechas en las que no estará disponible.
* Un servidor no puede ser asignado a más de un rol dentro del mismo evento.
* Los servidores nunca se eliminan; solo se desactivan.

## Ministerios

* Un ministerio pertenece a una iglesia.
* Cada ministerio posee un coordinador.
* Un ministerio administra sus propios roles.

## Roles

* Un rol pertenece a un único ministerio.
* Un rol puede definir un tiempo sugerido de preparación previo al evento.
* Los roles pueden desactivarse sin perder el historial.

## Eventos Programados

* Un evento programado define un evento recurrente.
* Un evento programado posee uno o más roles requeridos.
* Cada rol requerido define la cantidad de servidores necesarios.
* Los eventos programados pueden modificarse o eliminarse.

## Eventos

* Un evento representa una fecha específica.
* Los eventos se generan manualmente en el MVP.
* Los eventos contienen las asignaciones de servidores.
* Los eventos pasados forman parte del historial y no deben eliminarse.
* Un evento puede involucrar varios ministerios mediante los roles requeridos.

## Asignaciones

* Solo puede asignarse un servidor que posea el rol correspondiente.
* Un servidor no puede ocupar más de un rol dentro del mismo evento.
* Si un servidor ya fue asignado al evento, no podrá ser seleccionado nuevamente.
* Las asignaciones pertenecen al historial del evento.
