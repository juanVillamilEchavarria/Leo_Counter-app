<?php

namespace App\Domains\Presupuesto\Contracts\Repositories;
use App\Domains\Presupuesto\Aggregates\Presupuesto;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Contracts\Repositories\SoftDeleteRepositoryContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Contrato para el repositorio de presupuestos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Presupuesto\Contracts\Repositories
 * @version 1.0.0
 * @since 1.0.0
 */
interface PresupuestoRepositoryContract extends SoftDeleteRepositoryContract
{
    /**
     * Crea un nuevo presupuesto.
     * @param Presupuesto $presupuesto
     * @return Presupuesto
     */
    public function store(AggregateModelContract $presupuesto): AggregateModelContract;
    /**
     * Actualiza un presupuesto existente.
     * @param Presupuesto $presupuesto
     * @return bool
     */
    public function update(AggregateModelContract $presupuesto): bool;
    /**
     * Elimina un presupuesto por su ID.
     * @param PresupuestoId $id
     * @return bool
     */
    public function destroy(AggregateModelIdContract $id): bool;
    /**
     * Obtiene un agregado de presupuesto por su ID.
     * @param PresupuestoId $id
     * @return Presupuesto
     */
    public function findById(AggregateModelIdContract $id): ?AggregateModelContract;
}
