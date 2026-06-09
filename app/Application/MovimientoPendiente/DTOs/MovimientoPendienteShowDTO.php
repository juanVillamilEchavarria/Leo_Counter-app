<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\DTOs;

/**
 * DTO que encapsula los datos necesarios para mostrar con detalle un movimiento pendiente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoPendienteShowDTO
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
        public ?int $dias_aviso
    ) {
    }
}
