<?php

namespace App\Application\Movimiento\Events;

use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;

/**
 * Evento de gestión de archivos que se dispara cuando se crea un movimiento manual.
 * Transporta únicamente el movimiento y los comprobantes; los datos adicionales
 * se resolverán desde los handlers mediante repositorios/queries.
 */
final readonly class AttachmentsForMovimientoCreated implements UploadAttachmentsForMovimientoEventContract, MovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private array $comprobantes,
        private Date $fecha = new Date(new \DateTimeImmutable())
    ) {
    }

    public function getMovimiento(): Movimiento
    {
        return $this->movimiento;
    }

    public function getComprobantes(): array
    {
        return $this->comprobantes;
    }

    public function ocurredOn(): Date
    {
        return $this->fecha;
    }
}
