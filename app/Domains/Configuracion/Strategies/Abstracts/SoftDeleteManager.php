<?php

namespace App\Domains\Configuracion\Strategies\Abstracts;

use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Exceptions\CannotHardDeleteModel;
use App\Shared\Contracts\Repositories\SoftDeleteRepositoryContract;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Clase padre para las estrategias de manejo de registros eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Configuracion\Strategies\Abstracts
 * @since 1.0.0
 * @version 1.0.0
 */
abstract readonly class SoftDeleteManager implements SoftDeleteManagerContract{
    /**
     * Tipo de dominio, variable con la cual va a ser comparada en el metodo supports
     * @var SoftDeleteManagerTypes $domainType
     */
    protected SoftDeleteManagerTypes $domainType;



    public function __construct(
        /**
         * Repositorio write de soft delete
         * @var SoftDeleteRepositoryContract
         */
        protected SoftDeleteRepositoryContract $repository
    )
    {
    }

    /**
     * Normaliza el id para que sea compatible con el repositorio
     * devuelve el id del dominio especifico
     * @param string $id
     * @return AggregateModelIdContract
     */
    abstract protected function normalizeId(string $id): AggregateModelIdContract;
   abstract public function supports(SoftDeleteManagerTypes $domainType): bool;
    public function restore(AggregateModelIdContract $id) : bool
    {
        return $this->repository->restore($id);
    }

    public function hardDelete(AggregateModelIdContract $id): bool
    {
        if(!$this->canDelete($id)){
            throw new CannotHardDeleteModel('no se puede eliminar el registro, tiene registros relacionados');
        }
        return $this->repository->hardDelete($id);
    }

    public function findWithTrashed(string $id) : ?AggregateModelContract
    {
        $id = $this->normalizeId($id);
        return $this->repository->findByIdWithTrashed($id);
    }
    abstract public function canDelete(AggregateModelIdContract $id): bool;
}
