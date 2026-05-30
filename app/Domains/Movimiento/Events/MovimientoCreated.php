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

use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Contracts\Events\FinancialMovimientoRegisteredEventContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;

/**
 * Evento financiero que se dispara cuando se crea un movimiento manual.
 *
 * Contiene únicamente los datos necesarios para aplicar el impacto financiero
 * del movimiento sobre la cuenta. La gestión de comprobantes se publica en un
 * evento independiente.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 */
final readonly class MovimientoCreated implements FinancialMovimientoRegisteredEventContract, MovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private Date $fecha = new Date(new \DateTimeImmutable())
    )
    {
    }
    public function ocurredOn(): Date
    {
       return $this->fecha;
    }

    public function getMovimiento(): Movimiento
    {
        return $this->movimiento;
    }

}
