<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Events;

use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Events\DestroyAttachmentsForMovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de gestión de archivos que se dispara cuando se elimina un movimiento manual.
 *
 * Transporta únicamente los identificadores de comprobantes que deben ser
 * eliminados. No debe ser usado para revertir impacto financiero.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 */
final readonly class AttachmentsForMovimientoDeleted implements DestroyAttachmentsForMovimientoEventContract, MovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private ?array $comprobantes_delete_ids,
        private Date $fecha = new Date(new \DateTimeImmutable())
    ) {
    }

    public function getMovimiento(): Movimiento
    {
        return $this->movimiento;
    }

    public function getComprobantesDeleteIds(): ?array
    {
        return $this->comprobantes_delete_ids;
    }

    public function ocurredOn(): Date
    {
        return $this->fecha;
    }
}
