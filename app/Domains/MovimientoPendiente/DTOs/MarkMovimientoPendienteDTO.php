<?php
namespace App\Domains\MovimientoPendiente\DTOs;

use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Shared\DTOs\DTO;
class MarkMovimientoPendienteDTO extends DTO
{
    public function __construct(
        public ?EstadosMovimientoPendiente $estado
    ){}
}