# Entity Relationship Diagram

Este documento define el modelo conceptual del sistema **Coordina**.
No describe todavía la implementación en Laravel ni el diseño físico de la base de datos.
Su objetivo es dejar claras las entidades principales y cómo se relacionan.

## Diagrama Mermaid

```mermaid
erDiagram

    IGLESIA {
        bigint id
        string nombre
        string direccion
        boolean activo
    }

    USUARIO {
        bigint id
        bigint iglesia_id
        bigint servidor_id
        bigint ministerio_id
        string email
        string password
        string rol_acceso
        boolean activo
    }

    SERVIDOR {
        bigint id
        bigint iglesia_id
        string nombre
        string apellido
        string telefono
        string email_contacto
        boolean activo
    }

    MINISTERIO {
        bigint id
        bigint iglesia_id
        bigint coordinador_usuario_id
        string nombre
        string descripcion
        boolean activo
    }

    ROL {
        bigint id
        bigint ministerio_id
        string nombre
        integer minutos_preparacion
        boolean activo
    }

    SERVIDOR_ROL {
        bigint servidor_id
        bigint rol_id
    }

    DISPONIBILIDAD {
        bigint id
        bigint servidor_id
        date fecha
        string motivo
    }

    PLANTILLA_EVENTO {
        bigint id
        bigint iglesia_id
        string nombre
        integer dia_semana
        time hora_inicio
        integer duracion_minutos
        boolean activo
    }

    EVENTO_ROL {
        bigint id
        bigint plantilla_evento_id
        bigint rol_id
        integer cantidad
    }

    EVENTO {
        bigint id
        bigint plantilla_evento_id
        date fecha
        string estado
    }

    ASIGNACION {
        bigint id
        bigint evento_id
        bigint evento_rol_id
        bigint servidor_id
        string estado
    }

    IGLESIA ||--o{ USUARIO : tiene
    IGLESIA ||--o{ SERVIDOR : tiene
    IGLESIA ||--o{ MINISTERIO : tiene
    IGLESIA ||--o{ PLANTILLA_EVENTO : tiene

    USUARIO ||--o| SERVIDOR : puede_representar
    USUARIO ||--o| MINISTERIO : puede_coordinar

    MINISTERIO ||--o{ ROL : contiene

    SERVIDOR ||--o{ SERVIDOR_ROL : posee
    ROL ||--o{ SERVIDOR_ROL : asignado

    SERVIDOR ||--o{ DISPONIBILIDAD : registra

    PLANTILLA_EVENTO ||--o{ EVENTO_ROL : requiere
    ROL ||--o{ EVENTO_ROL : participa

    PLANTILLA_EVENTO ||--o{ EVENTO : genera

    EVENTO ||--o{ ASIGNACION : contiene
    EVENTO_ROL ||--o{ ASIGNACION : cubre
    SERVIDOR ||--o{ ASIGNACION : recibe
```

## Definición de entidades

### Iglesia

Entidad raíz del sistema.
Toda la información pertenece a una iglesia específica y no se comparte con otras iglesias.

### Usuario

Cuenta de acceso al sistema.
Puede existir sin estar asociada a un servidor.

### Servidor

Persona que presta servicio dentro de la iglesia.
Puede tener múltiples roles, disponibilidad y usuario asociado opcional.

### Ministerio

Área de servicio dentro de una iglesia.
Ejemplos: Multimedia, Audio, Alabanza.

### Rol

Función que puede cumplir un servidor.
Cada rol pertenece a un único ministerio.

### PlantillaEvento

Define un evento recurrente.
Ejemplo: “Culto domingo 19:00”.

### EventoRol

Define qué rol necesita una plantilla de evento y cuántas personas requiere.
Ejemplo: Cámara x2, Sonido x1, OBS x1.

### Evento

Representa una fecha concreta generada desde una plantilla de evento.

### Asignacion

Relaciona un servidor con un rol requerido dentro de un evento.
Representa que ese servidor cubre ese rol en esa fecha.

### Disponibilidad

Representa una fecha en la que un servidor no puede servir.

## Reglas importantes

* Toda la información pertenece a una iglesia.
* Un servidor puede tener múltiples roles.
* Un rol pertenece a un único ministerio.
* Un evento puede involucrar varios ministerios indirectamente mediante sus roles.
* Un servidor no puede tener más de una asignación dentro del mismo evento.
* Las asignaciones conservan historial.
* Las entidades no se eliminan físicamente; se desactivan.
* Un usuario puede estar asociado a un servidor, pero no es obligatorio.
* Un usuario también puede ser coordinador de un ministerio.
