<?php

namespace App\Application\Movimiento\Commands;

use App\Application\Movimiento\Commands\Abstracts\WriteMovimientoCommand;
use App\Shared\Application\Contracts\ValueObjects\UploadedFileContract;
use App\Shared\Application\Contracts\Commands\TransactionalCommandContract;

/**
 * Comando para actualizar un registro de movimiento.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateMovimientoCommand extends WriteMovimientoCommand implements TransactionalCommandContract
{
    /**
     * @param string $id
     * @param string $nombre
     * @param string $cuenta_id
     * @param string $categoria_id
     * @param int $tipo_movimiento_id
     * @param float $monto
     * @param string|null $descripcion
     * @param string|null $movimiento_pendiente_id
     * @param array<UploadedFileContract> $comprobantes - arreglo de los comprobantes nuevos
     * @param array|null $comprobantes_existing - arreglo que contiene los ids de los comprobantes existentes para este movimiento
     * @param array|null $comprobantes_delete_ids - arreglo que contiene los ids de los comprobantes a eliminar
     *
     */
    public function __construct(
        public string $id,
        string $nombre,
        string $cuenta_id,
        string $categoria_id,
        int $tipo_movimiento_id,
        float $monto,

        /** @var  */
        array $comprobantes,
        /**
         * @var array|null $comprobantes_existing - arreglo que contiene los ids de los comprobantes existentes para este movimiento
         */
        public ?array $comprobantes_existing =null,
        /**
         * @var array|null $comprobantes_delete_ids - arreglo que contiene los ids de los comprobantes a eliminar
         */
        public ?array $comprobantes_delete_ids = null ,
        ?string $descripcion = null,
        ?string $movimiento_pendiente_id = null,
    )
    {
        parent::__construct($nombre, $cuenta_id, $categoria_id, $tipo_movimiento_id, $monto,$comprobantes, $descripcion, $movimiento_pendiente_id);
    }
}
