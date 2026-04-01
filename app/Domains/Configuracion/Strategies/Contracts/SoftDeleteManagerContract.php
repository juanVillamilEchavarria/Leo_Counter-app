<?php

namespace App\Domains\Configuracion\Strategies\Contracts;
use App\Domains\Configuracion\Enums\DomainHandlerTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Contrato para las estrategias de manejo de registros eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Strategies\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
Interface SoftDeleteManagerContract{
    /**
     * Determina si esta estrategia es aplicable
     * @return bool
     */
    public function supports( DomainHandlerTypes $repositoryType) : bool;
    /**
     * Obtiene todos los registros eliminados
     * @return Collection<Model>
     */
    public function getAllDeleted(): Collection;
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
}