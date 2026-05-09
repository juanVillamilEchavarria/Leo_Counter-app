<?php

namespace App\Application\MovimientoPendiente\Commands\Abstracts;
abstract readonly class WriteMovimientoPendienteCommand
{
    public function __construct(
        public string $categoria_id,
        public int $tipo_movimiento_id,
        public string $cuenta_id,
        public string $nombre,
        public float $monto,
        public string $fecha_programada,
        public ?int $dias_aviso = null,
        public ?string $descripcion = null,

    )
    {
    }

}
