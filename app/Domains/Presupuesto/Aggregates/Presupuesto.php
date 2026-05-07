<?php

namespace App\Domains\Presupuesto\Aggregates;

use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoCanDuplicateCheckerContract;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use DateTimeImmutable;
/**
 * Agregado de dominio Presupuesto.
 * Representa un presupuesto del sistema con su información.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class Presupuesto implements AggregateModelContract
{
    private function __construct(
        private PresupuestoId $id,
        private string $categoria_id,
        private float $monto,
        private DateTimeImmutable $periodo,
        private ?string $descripcion,
        private string $user_id,
    ) {
    }
    /**
     * Crea un nuevo presupuesto.
     */

    public static function create(
        PresupuestoId $id,
        string $categoria_id,
        float $monto,
        DateTimeImmutable $periodo,
        ?string $descripcion,
        string $user_id,
        PresupuestoUniquenessCheckerContract $checker
    ): self {
        if(!$checker->isUnique($categoria_id, $periodo->format('Y-m'))) {
            throw new \App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException(
                message: 'Ya existe un presupuesto para la fecha seleccionada'
            );
        }
        return new self(
            id: $id,
            categoria_id: $categoria_id,
            monto: $monto,
            periodo: $periodo,
            descripcion: $descripcion,
            user_id: $user_id,
        );
    }
    /**
     * Reconstituye un presupuesto existente.
     * No aplica validaciones
     */

    public static function reconstitute(
        PresupuestoId $id,
        string $categoria_id,
        float $monto,
        DateTimeImmutable $periodo,
        ?string $descripcion,
        string $user_id
    ): self {
        return new self(
            id: $id,
            categoria_id: $categoria_id,
            monto: $monto,
            periodo: $periodo,
            descripcion: $descripcion,
            user_id: $user_id,
        );
    }

    /**
     * Actualiza los datos de un presupuesto existente
     */
    public function updateData(
        string $categoria_id,
        float $monto,
        ?string $descripcion,
        PresupuestoUniquenessCheckerContract $checker
    ): self {
        if (!$checker->isUnique($categoria_id, $this->periodo->format('Y-m'), $this->id)) {
            throw new \App\Domains\Presupuesto\Exceptions\CannotUpdatePresupuestoException(
                message: 'Ya existe un presupuesto para esta categoria en la fecha seleccionada'
            );
        }

        return new self(
            id: $this->id,
            categoria_id: $categoria_id,
            monto: $monto,
            periodo: $this->periodo,
            descripcion: $descripcion,
            user_id: $this->user_id,
        );
    }
    /**
     * Duplica un presupuesto
     */

    public function duplicate( PresupuestoId $id,PresupuestoCanDuplicateCheckerContract $checker): self
    {
        if (!$checker->canDuplicate($this->categoria_id, $this->periodo->format('Y-m'))) {
            throw new \App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException(
                message: 'Ya existe un presupuesto duplicado para este'
            );
        }

        return new self(
            id: $id,
            categoria_id: $this->categoria_id,
            monto: $this->monto,
            periodo: $this->periodo->add(new \DateInterval('P1M')),
            descripcion: $this->descripcion,
            user_id: $this->user_id,
        );
    }

    public function getId(): PresupuestoId
    {
        return $this->id;
    }
    public function getCategoriaId(): string
    {
        return $this->categoria_id;
    }

    public function getMonto(): float
    {
        return $this->monto;
    }

    public function getPeriodo(): DateTimeImmutable
    {
        return $this->periodo;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }
}
