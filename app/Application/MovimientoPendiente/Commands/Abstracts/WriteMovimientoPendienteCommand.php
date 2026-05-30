<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
