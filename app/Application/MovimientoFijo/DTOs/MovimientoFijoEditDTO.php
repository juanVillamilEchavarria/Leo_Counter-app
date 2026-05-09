<?php

namespace App\Application\MovimientoFijo\DTOs;

/**
 * DTO que encapsula los datos necesarios para editar un movimiento fijo.
 * Expone solo tipos primitivos para ser consumido por la capa de presentacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoFijoEditDTO
{
    public function __construct(
        public string $id,
        public string $categoria_id,
        public int $tipo_movimiento_id,
        public string $cuenta_id,
        public int $frecuencia_movimiento_id,
        public string $nombre,
        public float $monto,
        public string $fecha_proximo,
        public ?int $dias_aviso,
        public ?string $descripcion,
        public bool $active,
        public bool $registrar_automatico,
    ) {
    }
}
