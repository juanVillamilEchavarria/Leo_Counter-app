<?php

namespace App\Domains\Configuracion\Strategies\Resolvers;

use App\Domains\Configuracion\Strategies\Contracts\SoftDeleteManagerContract;
use App\Domains\Configuracion\Exceptions\CannotFindDomainHandlerException;
use App\Domains\Configuracion\Enums\DomainHandlerTypes;

class SoftDeleteManagerResolver{
    public function __construct(
        /**
         * @var iterable<SoftDeleteManagerContract>
         */
        private iterable $strategies
    )
    {
    }

    public function resolve(DomainHandlerTypes $repositoryType) : SoftDeleteManagerContract{
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($repositoryType)) {
                return $strategy;
            }
        }
        throw new CannotFindDomainHandlerException('No se pudo resolver la estrategia de manejo de registros eliminados');
    }
}