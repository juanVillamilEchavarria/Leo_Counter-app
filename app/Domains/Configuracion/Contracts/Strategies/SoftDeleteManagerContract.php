<?php

namespace App\Domains\Configuracion\Contracts\Strategies;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

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
     * @return bool
     */
    public function supports( SoftDeleteManagerTypes $repositoryType) : bool;
    /**
     * Obtiene todos los registros eliminados
     * @return Collection<Model>
     */
    public function getAllDeleted(): Collection | AnonymousResourceCollection;
    /**
     * Recupera un registro eliminado
     * @param Model $model
     * @return bool
     */
    public function restore(Model $model) : bool;
    /**
     * Elimina un registro de forma permanente
     * @param Model $model
     * @return bool
     */
    public function hardDelete(Model $model): bool;

    /**
     * Obtiene el registro eliminado por ID
     * @return Model
     */
    public function findWithTrashed(int $id) : ?Model;

    /**
     * Determina si se puede eliminar el registro
     * @return bool
     */
    public function canDelete(Model $model): bool;
}