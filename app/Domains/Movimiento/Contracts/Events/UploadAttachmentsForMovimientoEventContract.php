<?php

namespace App\Domains\Movimiento\Contracts\Events;

use App\Domains\Categoria\Aggregates\Categoria;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Contrato de evento de subida de archivos de un movimiento
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Contracts\Events
 * @version 1.0.0
 */
interface UploadAttachmentsForMovimientoEventContract extends EventContract
{
    public function getMovimiento(): Movimiento;
    public function getComprobantes() : array;
    public function getCategoria(): Categoria;
    public function getTipoMovimientoName(): string;

}
