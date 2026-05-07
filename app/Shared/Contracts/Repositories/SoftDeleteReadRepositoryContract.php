<?php

namespace App\Shared\Contracts\Repositories;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
/**
 * Contrato que implementaran los repositorios de lectura que su modelo tiene soft deletes, para obtener los registros eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface SoftDeleteReadRepositoryContract {
    /**
     * Obtiene todos los registros eliminados
     * @return Collection<Model>
     */
    public function getAllDeleted() : Collection;
    /**
     * Obtiene un registro por ID incluyendo los registros eliminados.
     * @param string|int $id
     * @return ?Model
     */
    public function findWithTrashed(string|int $id): ?Model;
    /**
     * Determina si el modelo tiene registros en relaciones 
     * @param Model $model
     * @return bool
     */
    public function hasRelationsRecords(Model $model): bool;
}