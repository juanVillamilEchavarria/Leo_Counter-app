<?php

namespace App\Domains\Configuracion\Services;
use App\Infrastructure\Persistence\Resolvers\SoftDeleteManagerResolver;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Exceptions\CannotFindModelException;

class ConfiguracionDeletedDomainService {
    public function __construct(
       private SoftDeleteManagerResolver $deletedDomainHandlerResolver
    )
    {
    }
    public function getAllDeleted(SoftDeleteManagerTypes $softDeleteManager){
        return $this->deletedDomainHandlerResolver->resolve($softDeleteManager)->getAllDeleted();
    }

    public function restore(int $id, SoftDeleteManagerTypes $softDeleteManager) : bool{
        try {
             $manager = $this->deletedDomainHandlerResolver->resolve($softDeleteManager);
            return $manager->restore($manager->findWithTrashed($id));
        } catch (\Throwable $th) {
            throw new CannotFindModelException("No se pudo encontrar el registro : ".$th->getMessage());
        }
       
    }

    public function hardDelete(int $id, SoftDeleteManagerTypes $softDeleteManager) : bool{
        try {
             $manager = $this->deletedDomainHandlerResolver->resolve($softDeleteManager);
            return $manager->hardDelete($manager->findWithTrashed($id));
        } catch (\Throwable $th) {
            throw new CannotFindModelException("No se pudo encontrar el registro : ".$th->getMessage());
        }
       
    }
}