<?php

namespace App\Domains\Movimiento\Events;

use App\Domains\Categoria\Aggregates\Categoria;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Events\DestroyAttachmentsForMovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\UpdateAttachmentsForMovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de gestión de archivos que se dispara cuando se actualiza un movimiento manual.
 *
 * Transporta los comprobantes nuevos, existentes y a eliminar, además de los
 * datos necesarios para recalcular rutas cuando cambia la categoría o el tipo
 * de movimiento. No debe ser usado para aplicar impacto financiero.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 */
final readonly class AttachmentsForMovimientoUpdated implements UploadAttachmentsForMovimientoEventContract, UpdateAttachmentsForMovimientoEventContract, DestroyAttachmentsForMovimientoEventContract, MovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private Movimiento $oldMovimiento,
        private Categoria $categoria,
        private ?array $comprobantes,
        private ?array $comprobantes_existing,
        private ?array $comprobantes_delete_ids,
        private string $tipo_movimiento_name,
        private Date $fecha = new Date(new \DateTimeImmutable())
    ) {
    }

    public function getMovimiento(): Movimiento
    {
        return $this->movimiento;
    }

    public function getComprobantes(): array
    {
        return $this->comprobantes ?? [];
    }

    public function getComprobantesExisting(): ?array
    {
        return $this->comprobantes_existing;
    }

    public function getComprobantesDeleteIds(): ?array
    {
        return $this->comprobantes_delete_ids;
    }

    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }

    public function getTipoMovimientoName(): string
    {
        return $this->tipo_movimiento_name;
    }

    public function pathChanged(): bool
    {
        return $this->oldMovimiento->getTipoMovimientoId() !== $this->movimiento->getTipoMovimientoId()
            || !$this->oldMovimiento->getCategoriaId()->equals($this->movimiento->getCategoriaId());
    }

    public function ocurredOn(): Date
    {
        return $this->fecha;
    }
}
