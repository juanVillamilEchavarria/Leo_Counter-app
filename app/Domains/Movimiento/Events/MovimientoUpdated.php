<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Movimiento\Events;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento financiero que se dispara cuando se actualiza un movimiento manual.
 *
 * Contiene únicamente el estado nuevo y anterior necesario para revertir y
 * aplicar el impacto financiero. La gestión de comprobantes se publica en un
 * evento independiente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 */
final readonly class MovimientoUpdated implements MovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private Cuenta $cuenta,
        private Movimiento $oldMovimiento,
        private Cuenta $oldCuenta,
        private Date $fecha = new Date(new \DateTimeImmutable())
    )
    {
    }
    public function tipoMovimientoChanged(): bool{
        return $this->movimiento->getTipoMovimientoId() !== $this->oldMovimiento->getTipoMovimientoId();
    }
    public function cuentaChanged(): bool{
        return !$this->movimiento->getCuentaId()->equals($this->oldMovimiento->getCuentaId());
    }

    public function getMovimiento(): Movimiento
    {
        return $this->movimiento;
    }

    public function getCuenta(): Cuenta
    {
        return $this->cuenta;
    }
    public function getOldMovimiento(): Movimiento
    {
        return $this->oldMovimiento;
    }
    public function getOldCuenta(): Cuenta
    {
        return $this->oldCuenta;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->fecha;
    }
}
