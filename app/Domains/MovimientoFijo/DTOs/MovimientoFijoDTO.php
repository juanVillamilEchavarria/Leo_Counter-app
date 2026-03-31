<?php

namespace App\Domains\MovimientoFijo\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Support\Carbon;
use App\Domains\MovimientoFijo\DTOs\Contracts\MovimientoFijoDTOContract;

abstract class MovimientoFijoDTO extends DTO implements MovimientoFijoDTOContract{
    public function __construct(
        public readonly int $cuenta_id,
        public readonly int $categoria_id,
        public readonly int $tipo_movimiento_id,
        public readonly int $frecuencia_movimiento_id,
        public readonly string $nombre,
        public readonly float $monto,
        public readonly string $fecha_proximo,
        public readonly ?int $dias_aviso = null,
        public readonly ?string $descripcion = null,
    )
    {
        $this->fecha_proximo = Carbon::parse($fecha_proximo);
    }
}