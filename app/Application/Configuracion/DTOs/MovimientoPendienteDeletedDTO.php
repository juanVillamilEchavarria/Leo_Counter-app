<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\DTOs;

/**
 * DTO para representar un movimiento pendiente eliminado con metadata para presentacion.
 *
 * @package App\Application\Configuracion\DTOs
 */
final readonly class MovimientoPendienteDeletedDTO
{
    /**
     * @param string $id
     * @param string|null $nombre
     * @param float $monto
     * @param string|null $fecha_programada
     * @param string|null $estado
     * @param string|null $deleted_at
     * @param bool $can_hard_delete
     */
    public function __construct(
        public string $id,
        public ?string $nombre,
        public float $monto,
        public ?string $fecha_programada,
        public ?string $estado,
        public ?string $deleted_at,
        public bool $can_hard_delete
    ){
    }
}
