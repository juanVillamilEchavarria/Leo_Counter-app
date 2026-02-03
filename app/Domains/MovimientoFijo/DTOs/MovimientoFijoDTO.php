<?php

namespace App\Domains\MovimientoFijo\DTOs;

use App\Shared\DTOs\DTO;
use Illuminate\Support\Carbon;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;

class MovimientoFijoDTO extends DTO{
    public function __construct(
        public ?int $cuenta_id,
        public ?int $categoria_id,
        public ?int $tipo_movimiento_id,
        public ?int $frecuencia_movimiento_id,
        public ?string $nombre,
        public ?float $monto,
        public ?string $fecha_proximo,
        public ?int $dias_aviso = null,
        public ?string $descripcion = null,
        public ?string $url_pago = null,
    )
    {
        $this->fecha_proximo = Carbon::parse($fecha_proximo);
    }
}