<?php

namespace App\Application\MovimientoPendiente\DTOs;
use Illuminate\Database\Eloquent\Collection;
use App\Shared\Abstracts\DTOs\DTO;

class MovimientoPendienteFormOptionsDTO extends DTO{
    public function __construct(
        public ?Collection $categorias,
        public ?Collection $tipos_movimientos,
        public ?Collection $cuentas,
        public ?Collection $movimientos_fijos
    )
    {
    }

}
