<?php

namespace App\Domains\Configuracion\Strategies\Domain\SoftDeleteManagers\Categoria;
use App\Domains\Configuracion\Strategies\Abstracts\SoftDeleteManager;
use App\Domains\Configuracion\Strategies\Contracts\SoftDeleteManagerContract;
use App\Domains\Categoria\Repositories\Contracts\CategoriaReadRepositoryContract;
use App\Domains\Categoria\Repositories\Contracts\CategoriaWriteRepositoryContract;
use App\Domains\Configuracion\Enums\DomainHandlerTypes;

class SoftDeleteCategoriaManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    protected DomainHandlerTypes $domainType = DomainHandlerTypes::CATEGORIAS;
    public function __construct(
        CategoriaReadRepositoryContract $readRepository,
        CategoriaWriteRepositoryContract $writeRepository
    ) {
        parent::__construct($readRepository, $writeRepository);
    }
}