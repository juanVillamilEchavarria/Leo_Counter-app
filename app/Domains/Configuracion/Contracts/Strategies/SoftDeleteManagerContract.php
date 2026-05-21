<?php

namespace App\Domains\Configuracion\Contracts\Strategies;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Contrato para las estrategias de manejo de registros eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Contracts\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
Interface SoftDeleteManagerContract{
    /**
     * Determina si esta estrategia es aplicable
     * @param SoftDeleteManagerTypes $repositoryType
     * @return bool
     */
    public function supports( SoftDeleteManagerTypes $repositoryType) : bool;
    /**
     * Recupera un registro eliminado
     * @param AggregateModelIdContract $id
     * @return bool
     */
    public function restore(AggregateModelIdContract $id) : bool;
    /**
     * Elimina un registro de forma permanente
     * @param AggregateModelIdContract $id
     * @return bool
     */
    public function hardDelete(AggregateModelIdContract $id): bool;

    /**
     *
     * Obtiene el registro eliminado por ID
     *
     * @param string $id - se pasa como string para que cada uno lo parsee a su respectivo id de dominio
     * @return AggregateModelContract | null
     */
    public function findWithTrashed(string $id) : ?AggregateModelContract;

    /**
     * Determina si se puede eliminar el registro
     * @param AggregateModelIdContract $id
     * @return bool
     */
    public function canDelete(AggregateModelIdContract $id): bool;
}
