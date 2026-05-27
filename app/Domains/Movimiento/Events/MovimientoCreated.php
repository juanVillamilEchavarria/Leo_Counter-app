<?php

namespace App\Domains\Movimiento\Events;

use App\Domains\Categoria\Aggregates\Categoria;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Contracts\Events\FinancialMovimientoRegisteredEventContract;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;

/**
 * Evento que se dispara cuando se crea un movimiento.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 */
final readonly class MovimientoCreated implements UploadAttachmentsForMovimientoEventContract, MovimientoEventContract, FinancialMovimientoRegisteredEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private Cuenta $cuenta,
        private Categoria $categoria,
        private array $comprobantes,
        private string $tipo_movimiento_name,
        private Date $fecha =new Date(new \DateTimeImmutable())
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
    public function getCuenta(): Cuenta
    {
        return $this->cuenta;
    }
    public function getComprobantes(): array
    {
        return $this->comprobantes;
    }

    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }
    public function getTipoMovimientoName(): string
    {
        return $this->tipo_movimiento_name;
    }

}
