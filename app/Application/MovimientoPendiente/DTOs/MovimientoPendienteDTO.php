<?php

namespace App\Application\MovimientoPendiente\DTOs;

use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Carbon;

class MovimientoPendienteDTO extends DTO{
    public function __construct(
        public ?int $cuenta_id,
        public ?int $categoria_id,
        public ?int $tipo_movimiento_id,
        public ?string $nombre,
        public ?float $monto,
        public ?string $fecha_programada,
        public ?int $dias_aviso = null,
        public ?string $descripcion = null,
        public ?EstadosMovimientoPendiente $estado= EstadosMovimientoPendiente::PENDIENTE
    )
    {
        $this->fecha_programada = Carbon::parse($fecha_programada);
    }
}
