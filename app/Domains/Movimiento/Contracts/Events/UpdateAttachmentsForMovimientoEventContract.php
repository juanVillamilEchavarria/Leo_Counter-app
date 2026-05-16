<?php

namespace App\Domains\Movimiento\Contracts\Events;

use App\Domains\Categoria\Aggregates\Categoria;
use App\Shared\Domain\Contracts\EventContract;
/**
 * Contrato que representa un evento que dispara la actualizacion de los comprobantes de un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface UpdateAttachmentsForMovimientoEventContract extends EventContract
{
    /**
     * Obtiene los comprobantes existentes a mover y actualizar
     * @return array|null
     */
    public function getComprobantesExisting(): ?array;
    public function getCategoria(): Categoria;
    public function getTipoMovimientoName(): string;

}
