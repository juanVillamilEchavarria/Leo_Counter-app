<?php

namespace App\Application\MovimientoPendiente\DTOs;

use App\Application\MovimientoPendiente\DTOs\MovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;

class UpdateMovimientoPendienteDTO extends MovimientoPendienteDTO{

    protected array $except =[
        'estado'
        
    ];
}
