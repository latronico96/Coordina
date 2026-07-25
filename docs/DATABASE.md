# Modelo de dominio

## Entidades principales

* Iglesia
* Usuario
* Servidor
* Ministerio
* Rol
* Evento Programado
* Rol Requerido
* Evento
* Asignación
* Disponibilidad

## Relaciones

Iglesia

* tiene muchos Usuarios
* tiene muchos Servidores
* tiene muchos Ministerios
* tiene muchos Eventos Programados
* tiene muchos Eventos

Usuario

* pertenece a una Iglesia
* puede pertenecer a un Servidor

Servidor

* pertenece a una Iglesia
* puede tener un Usuario
* posee múltiples Roles
* posee múltiples Disponibilidades
* posee múltiples Asignaciones

Ministerio

* pertenece a una Iglesia
* posee un Coordinador
* posee múltiples Roles

Rol

* pertenece a un Ministerio
* puede pertenecer a múltiples Servidores
* puede formar parte de múltiples Roles Requeridos

Evento Programado

* pertenece a una Iglesia
* posee múltiples Roles Requeridos
* genera múltiples Eventos

Rol Requerido

* pertenece a un Evento Programado
* referencia un Rol
* define la cantidad necesaria de servidores

Evento

* pertenece a un Evento Programado
* posee múltiples Asignaciones

Asignación

* pertenece a un Evento
* pertenece a un Rol Requerido
* pertenece a un Servidor

Disponibilidad

* pertenece a un Servidor
* representa una fecha en la que el servidor no puede prestar servicio.
