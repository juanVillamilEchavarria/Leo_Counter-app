<?php

namespace App\Infrastructure\AbstractPersistence\Strategies;

use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Contracts\Repositories\SoftDeleteReadRepositoryContract;
use App\Shared\Contracts\Repositories\SoftDeleteRepositoryContract;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Configuracion\Exceptions\CannotHardDeleteModel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
/**
 * Clase padre para las estrategias de manejo de registros eliminados
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Infrastructure\AbstractPersistence\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
abstract class SoftDeleteManager implements SoftDeleteManagerContract{
    /**
     * Tipo de dominio, variable con la cual va a ser comparada en el metodo supports
     * @var SoftDeleteManagerTypes
     */
    protected SoftDeleteManagerTypes $domainType;

    /**
     * Recurso para devolver los registros eliminados en una coleccion, debe ser un recurso de App\Http\Resources\Configuracion\Abstracts\SoftDeleteResource
     * @var ?string
     */
    protected ?string $resource = null;


    public function __construct(
        /**
         * Repositorio read de soft delete
         * @var SoftDeleteReadRepositoryContract
         */
        protected SoftDeleteReadRepositoryContract $readRepository,
        /**
         * Repositorio write de soft delete
         * @var SoftDeleteRepositoryContract
         */
        protected SoftDeleteRepositoryContract $writeRepository
    )
    {
    }

    public function supports(SoftDeleteManagerTypes $domainType): bool
    {
        return $this->domainType === $domainType;
    }
    public function getAllDeleted() : Collection | AnonymousResourceCollection
    {
        if($this->resource !== null){
            $collection = $this->resource::collection($this->readRepository->getAllDeleted());
            $collection->each->setManager($this);
            return $collection;
        }
        return  $this->readRepository->getAllDeleted();
    }
    public function restore(Model $model) : bool
    {
        return $this->writeRepository->restore($model);
    }

    public function hardDelete(Model $model): bool
    {
        if(!$this->canDelete($model)){
            throw new CannotHardDeleteModel('no se puede eliminar el registro, tiene registros relacionados');
        }
        return $this->writeRepository->hardDelete($model);
    }

    public function findWithTrashed(int $id) : ?Model
    {
        return $this->readRepository->findWithTrashed($id);
    }

    public function canDelete(Model $model): bool{
        return !$this->readRepository->hasRelationsRecords($model);
    }
}