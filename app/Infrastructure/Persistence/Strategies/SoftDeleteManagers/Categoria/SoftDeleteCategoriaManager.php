<?php

namespace App\Infrastructure\Persistence\Strategies\SoftDeleteManagers\Categoria;
use App\Infrastructure\AbstractPersistence\Strategies\SoftDeleteManager;
use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaReadRepositoryContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Http\Resources\Configuracion\SoftDeletesManagers\Categoria\DeletedCategoriaResource;

class SoftDeleteCategoriaManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    protected SoftDeleteManagerTypes $domainType = SoftDeleteManagerTypes::CATEGORIAS;
    protected ?string $resource = DeletedCategoriaResource::class;
    public function __construct(
        CategoriaReadRepositoryContract $readRepository,
        CategoriaRepositoryContract $writeRepository
    ) {
        parent::__construct($readRepository, $writeRepository);
    }

}