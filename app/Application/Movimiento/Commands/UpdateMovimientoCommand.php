<?php

namespace App\Application\Movimiento\Commands;

use App\Application\Movimiento\Commands\Abstracts\WriteMovimientoCommand;

/**
 * Comando para actualizar un registro de movimiento.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateMovimientoCommand extends WriteMovimientoCommand
{
    public function __construct(
        public string $id,
        string $nombre,
        string $cuenta_id,
        string $categoria_id,
        int $tipo_movimiento_id,
        float $monto,
        ?string $descripcion = null,
        ?string $movimiento_pendiente_id = null,
        ?array $comprobantes = null,
        /**
         * @var array|null $comprobantes_existing - arreglo que contiene los ids de los comprobantes existentes para este movimiento
         */
        public ?array $comprobantes_existing =null,
        /**
         * @var array|null $comprobantes_delete_ids - arreglo que contiene los ids de los comprobantes a eliminar
         */
        public ?array $comprobantes_delete_ids = null
    )
    {
        parent::__construct($nombre, $cuenta_id, $categoria_id, $tipo_movimiento_id, $monto, $descripcion, $movimiento_pendiente_id, $comprobantes);
    }
}
