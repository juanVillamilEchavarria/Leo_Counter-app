<?php

namespace App\Application\Movimiento\Commands\Abstracts;

/**
 * Comando abstracto para escritura de movimientos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
abstract readonly class WriteMovimientoCommand{
    public function __construct(
        public string $nombre,
        public string $cuenta_id,
        public string $categoria_id,
        public int $tipo_movimiento_id,
        public float $monto,
        public ?string $descripcion = null,
        public ?string $movimiento_pendiente_id = null,
        public  ?array $comprobantes = null
    )
    {
    }

}
