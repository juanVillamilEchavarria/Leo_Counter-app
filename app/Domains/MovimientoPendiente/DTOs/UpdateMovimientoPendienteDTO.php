<?php

namespace App\Domains\MovimientoPendiente\DTOs;

use App\Domains\MovimientoPendiente\DTOs\MovimientoPendienteDTO;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;

class UpdateMovimientoPendienteDTO extends MovimientoPendienteDTO{

    protected array $except =[
        'estado'
        
    ];
}
