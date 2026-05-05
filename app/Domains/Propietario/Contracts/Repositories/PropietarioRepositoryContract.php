<?php

namespace App\Domains\Propietario\Contracts\Repositories;

use App\Domains\Propietario\Aggregates\Propietario as PropietarioAggregate;
use App\Shared\Domain\Contracts\AggregateModelContract;

/**
 * Contrato de implementación de repositorio de escritura para el dominio Propietario.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Propietario\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface PropietarioRepositoryContract
{
    /**
     * Guarda un nuevo propietario en la persistencia.
     * @param PropietarioAggregate $propietario
     * @return AggregateModelContract
     */
    public function store(object $propietario): AggregateModelContract;

    /**
     * Actualiza un propietario existente.
     * @param PropietarioAggregate $propietario
     * @param int $id
     * @return bool
     */
    public function update(object $propietario, int $id): bool;

    /**
     * Elimina un propietario existente por su ID.
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * Busca un propietario por su ID y lo reconstituye como agregado.
     * @param int $id
     * @return PropietarioAggregate|null
     */
    public function findById(int $id): ?AggregateModelContract;
}
