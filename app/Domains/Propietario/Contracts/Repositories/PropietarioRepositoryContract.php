<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Propietario\Contracts\Repositories;

use App\Domains\Propietario\Aggregates\Propietario as PropietarioAggregate;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\Contracts\SoftDeleteRepositoryContract;

/**
 * Contrato de implementación de repositorio de escritura para el dominio Propietario.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Propietario\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface PropietarioRepositoryContract extends SoftDeleteRepositoryContract
{
    /**
     * Guarda un nuevo propietario en la persistencia.
     * @param PropietarioAggregate $propietario
     * @return AggregateModelContract
     */
    public function store(AggregateModelContract $propietario): AggregateModelContract;

    /**
     * Actualiza un propietario existente.
     * @param PropietarioAggregate $propietario
     * @return bool
     */
    public function update(AggregateModelContract $propietario): bool;

    /**
     * Elimina un propietario existente por su ID.
     * @param \App\Domains\Propietario\ValueObjects\PropietarioId $id
     * @return bool
     */
    public function destroy(AggregateModelIdContract $id): bool;

    /**
     * Busca un propietario por su ID y lo reconstituye como agregado.
     * @param \App\Domains\Propietario\ValueObjects\PropietarioId $id
     * @return PropietarioAggregate|null
     */
    public function findById(AggregateModelIdContract $id): ?AggregateModelContract;
}
