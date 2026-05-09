<?php

namespace App\Application\MovimientoFijo\Commands\Abstracts;

/**
 * Comando base para las operaciones de escritura de MovimientoFijo.
 * Centraliza los campos compartidos entre creacion y actualizacion para evitar duplicacion
 * en los comandos concretos de la capa de aplicacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Commands\Abstracts
 * @since 1.0.0
 * @version 1.0.0
 */
abstract readonly class WriteMovimientoFijoCommand
{
    public function __construct(
        public string $categoria_id,
        public int $tipo_movimiento_id,
        public string $cuenta_id,
        public int $frecuencia_movimiento_id,
        public string $nombre,
        public float $monto,
        public string $fecha_proximo,
        public ?int $dias_aviso = null,
        public ?string $descripcion = null,
    ) {
    }
}
