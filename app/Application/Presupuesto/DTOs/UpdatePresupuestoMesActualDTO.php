<?php

namespace App\Application\Presupuesto\DTOs;

use App\Application\Presupuesto\DTOs\PresupuestoDTO;

class UpdatePresupuestoMesActualDTO extends PresupuestoDTO
{
    protected array $except = [
        'periodo'
    ];
}
