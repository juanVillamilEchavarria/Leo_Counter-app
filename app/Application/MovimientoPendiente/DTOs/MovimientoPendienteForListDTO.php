<?php

namespace App\Application\MovimientoPendiente\DTOs;

/**
 * DTO que representa un movimiento pendiente para listado.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoPendienteForListDTO
{
    public function __construct(
        public string $id,
        public string $nombre,
        public ?string $descripcion,
        public string $tipo_movimiento,
        public string $categoria,
        public string $cuenta,
        public ?string $movimiento_fijo,
        public string $fecha_programada,
        public float $monto,
        public string $estado,
        public int $dias_aviso,
        public ?bool $enough_balance
    )
    {
    }

}
