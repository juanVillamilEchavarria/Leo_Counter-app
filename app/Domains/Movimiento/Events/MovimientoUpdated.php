<?php

namespace App\Domains\Movimiento\Events;

use App\Domains\Categoria\Aggregates\Categoria;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\UpdateAttachmentsForMovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\DestroyAttachmentsForMovimientoEventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de actualización de un movimiento
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 */
final readonly class MovimientoUpdated implements UploadAttachmentsForMovimientoEventContract, UpdateAttachmentsForMovimientoEventContract, DestroyAttachmentsForMovimientoEventContract, MovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private Cuenta $cuenta,
        private Movimiento $oldMovimiento,
        private Cuenta $oldCuenta,
        private Categoria $categoria,
        private ?array $comprobantes_delete_ids,
        private ?array $comprobantes_existing,
        private array $comprobantes,
        private string $tipo_movimiento_name,
        private Date $fecha =new Date(new \DateTimeImmutable())
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
    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }
    public function getComprobantes(): array
    {
        return $this->comprobantes;
    }
    public function getComprobantesDeleteIds(): ?array
    {
       return $this->comprobantes_delete_ids;
    }
    public function getComprobantesExisting(): ?array
    {
        return $this->comprobantes_existing;
    }
    public function pathChanged(): bool
    {
      return $this->oldMovimiento->getTipoMovimientoId() !== $this->movimiento->getTipoMovimientoId() || $this->oldMovimiento->getCategoriaId() !== $this->movimiento->getCategoriaId();
    }

    public function getTipoMovimientoName(): string
    {
        return $this->tipo_movimiento_name;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->fecha;
    }
}
