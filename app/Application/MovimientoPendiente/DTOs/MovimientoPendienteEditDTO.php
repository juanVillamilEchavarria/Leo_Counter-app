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
 * DTO que encapsula los datos necesarios para editar un movimiento pendiente.
 * Expone solo tipos primitivos para ser consumido por la capa de presentacion sin
 * exponer value objects ni detalles del dominio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoPendienteEditDTO
{
    public function __construct(
        public string $id,
        public string $categoria_id,
        public string $cuenta_id,
        public int $tipo_movimiento_id,
        public string $nombre,
        public float $monto,
        public string $fecha_programada,
        public ?int $dias_aviso,
        public ?string $descripcion,
        public string $estado,
    ) {
    }
}
