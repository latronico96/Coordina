<?php

namespace App\Enums;

enum ActionTokenType: string
{
    case INVITACION = 'invitacion';
    case CONFIRMAR_ASIGNACION = 'confirmar_asignacion';
    case PASSWORD_RESET = 'password_reset';
    case RESET_PASSWORD = 'reset_password';
}
