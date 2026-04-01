<?php

namespace App\Domains\Configuracion\Strategies\Abstracts;

use App\Domains\Configuracion\Strategies\Contracts\SoftDeleteManagerContract;
use App\Domains\Configuracion\Enums\HandlerTypes;
use App\Domains\Configuracion\Enums\DomainHandlerTypes;
use App\Shared\Contracts\Repositories\SoftDeleteReadRepositoryContract;
use App\Shared\Contracts\Repositories\SoftDeleteWriteRepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
/**
 * Clase padre para las estrategias de manejo de registros eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Strategies\Abstracts
 * @since 1.0.0
 * @version 1.0.0
 */
abstract class SoftDeleteManager implements SoftDeleteManagerContract{
    /**
     * Tipo de dominio, variable con la cual va a ser comparada en el metodo supports
     * @var DomainHandlerTypes
     */
    protected DomainHandlerTypes $domainType;

    public function __construct(
        /**
         * Repositorio read de soft delete
         * @var SoftDeleteReadRepositoryContract
         */
        protected SoftDeleteReadRepositoryContract $readRepository,
        /**
         * Repositorio write de soft delete
         * @var SoftDeleteWriteRepositoryContract
         */
        protected SoftDeleteWriteRepositoryContract $writeRepository
    )
    {
    }

    public function supports(DomainHandlerTypes $domainType): bool
    {
        return $this->domainType === $domainType;
    }
    public function getAllDeleted() : Collection
    {
        return $this->readRepository->getAllDeleted();
    }
    public function restore(Model $model) : bool
    {
        return $this->writeRepository->restore($model);
    }
    public function hardDelete(Model $model): bool
    {
        return $this->writeRepository->hardDelete($model);
    }
}