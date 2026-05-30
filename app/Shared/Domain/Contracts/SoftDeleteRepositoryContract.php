<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Domain\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Contrato que implementaran todos los write repositories que su modelo tenga soft deletes, para poder recuperar y eliminar registros eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface SoftDeleteRepositoryContract
{
    /**
     * Recupera un registro eliminado
     * @param AggregateModelIdContract $id
     */
    public function restore(AggregateModelIdContract $id): bool;
    /**
     * Elimina un registro de forma permanente
     * @param AggregateModelIdContract $id
     */
    public function hardDelete(AggregateModelIdContract $id): bool;

    /**
     * Obtiene un registro eliminado por ID
     * @param AggregateModelIdContract $id
     * @return Model|null
     */
    public function findByIdWithTrashed(AggregateModelIdContract $id): ?AggregateModelContract;
}
