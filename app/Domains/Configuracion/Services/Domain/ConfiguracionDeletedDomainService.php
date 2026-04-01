<?php

namespace App\Domains\Configuracion\Services\Domain;
use App\Domains\Configuracion\Strategies\Resolvers\SoftDeleteManagerResolver;
use App\Domains\Configuracion\Enums\DomainHandlerTypes;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionDeletedDomainService {
    public function __construct(
       private SoftDeleteManagerResolver $deletedDomainHandlerResolver
    )
    {
    }

    public function getAllDeleted(DomainHandlerTypes $repositoryType){
        return $this->deletedDomainHandlerResolver->resolve($repositoryType)->getAllDeleted();
    }

    public function restore(Model $model, DomainHandlerTypes $repositoryType) : bool{
        return $this->deletedDomainHandlerResolver->resolve($repositoryType)->restore($model);
    }

    public function hardDelete(Model $model, DomainHandlerTypes $repositoryType) : bool{
        return $this->deletedDomainHandlerResolver->resolve($repositoryType)->hardDelete($model);
    }
}