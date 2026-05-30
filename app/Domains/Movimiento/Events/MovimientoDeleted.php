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
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\Movimiento\Aggregates\Movimiento;

/**
 * Evento financiero que se dispara cuando se elimina un movimiento manual.
 *
 * Contiene únicamente la información necesaria para revertir el impacto
 * financiero del movimiento. La eliminación de comprobantes se publica en un
 * evento independiente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 */
final readonly class MovimientoDeleted implements MovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private Movimiento $oldMovimiento,
        private Cuenta $cuenta,
        private Date $fecha = new Date(new \DateTimeImmutable())
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
    public function ocurredOn(): Date
    {
        return $this->fecha;
    }
}
