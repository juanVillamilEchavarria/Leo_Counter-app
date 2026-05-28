<?php

namespace App\Domains\Movimiento\Events;

use App\Domains\Categoria\Aggregates\Categoria;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Contracts\Events\MovimientoEventContract;
use App\Domains\Movimiento\Contracts\Events\UploadAttachmentsForMovimientoEventContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Evento de gestión de archivos que se dispara cuando se crea un movimiento manual.
 *
 * Transporta los comprobantes y los datos necesarios para construir la ruta de
 * almacenamiento. No debe ser usado para aplicar impacto financiero.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Movimiento\Events
 * @version 1.0.0
 */
final readonly class AttachmentsForMovimientoCreated implements UploadAttachmentsForMovimientoEventContract, MovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private Categoria $categoria,
        private array $comprobantes,
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

    public function ocurredOn(): Date
    {
        return $this->fecha;
    }
}
