<?php

namespace App\Domains\Notificacion\Enums;
use App\Domains\Notificacion\ValueObjects\CanalId;

enum CanalesNotificacionEnum : string
{
    /**
     * Se guarda el id del registro de email
     */
    CASE EMAIL = 'Email';

}
