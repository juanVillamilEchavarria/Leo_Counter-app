<?php

namespace App\Domains\Configuracion\Services\Application;

use App\Domains\Configuracion\Services\Domain\ConfiguracionDeletedDomainService;
use App\Domains\Configuracion\Enums\DomainHandlerTypes;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Configuracion\Exceptions\InvalidDomainType;
class ConfiguracionService{
    public function __construct(
        private ConfiguracionDeletedDomainService $configuracionDeletedDomainService
    )
    {
    }

    public function getAllDeleted(string $domain){
        
        return $this->configuracionDeletedDomainService->getAllDeleted($this->resolveDomainType($domain));
    }

    public function restore(Model $model, string $domain){
        return $this->configuracionDeletedDomainService->restore($model, $this->resolveDomainType($domain));
    }

    public function hardDelete(Model $model, string $domain){
        return $this->configuracionDeletedDomainService->hardDelete($model, $this->resolveDomainType($domain));
    }

    private function resolveDomainType(string $domain){
       try {
          return DomainHandlerTypes::from($domain);
       } catch (\Throwable $th) {
       
           throw new InvalidDomainType('Dominio invalido: '.$th->getMessage());
       }
    }
}