<?php
namespace App\Shared\Contracts\Repositories;

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
     * @param Model $model
     */
    public function restore(Model $model): bool;
    /**
     * Elimina un registro de forma permanente
     * @param Model $model
     */
    public function hardDelete(Model $model): bool;
}