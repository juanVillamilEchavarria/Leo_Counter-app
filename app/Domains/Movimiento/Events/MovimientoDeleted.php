<?php

namespace App\Domains\Movimiento\Events;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Contracts\Events\DestroyAttachmentsForMovimientoEventContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\Movimiento\Aggregates\Movimiento;

/**
 * Evento de eliminación de un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 */
final readonly class MovimientoDeleted implements DestroyAttachmentsForMovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private Movimiento $oldMovimiento,
        private Cuenta $cuenta,
        private ?array $comprobantes_delete_ids,
        private Date $fecha =new Date(new \DateTimeImmutable())
    )
    {
    }

    public function getOldMovimiento(): Movimiento
    {
        return $this->oldMovimiento;
    }
    public function getMovimiento(): Movimiento
    {
        return $this->movimiento;
    }
    /**
     * @return Cuenta
     */
    public function getCuenta(): Cuenta
    {
        return $this->cuenta;
    }

    /**
     * @inheritDoc
     */
    public function getComprobantesDeleteIds(): ?array
    {
        return $this->comprobantes_delete_ids;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->fecha;
    }
}
