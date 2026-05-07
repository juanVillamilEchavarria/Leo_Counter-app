<?php
namespace App\Shared\Contracts\Repositories;

use App\Shared\Domain\Contracts\AggregateModelIdContract;
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
     * @param int $id
     */
    public function restore(AggregateModelIdContract $id): bool;
    /**
     * Elimina un registro de forma permanente
     * @param int $id
     */
    public function hardDelete(AggregateModelIdContract $id): bool;
}