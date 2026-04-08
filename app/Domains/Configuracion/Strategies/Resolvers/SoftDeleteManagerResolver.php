<?php

namespace App\Domains\Configuracion\Strategies\Resolvers;

use App\Domains\Configuracion\Strategies\Contracts\SoftDeleteManagerContract;
use App\Domains\Configuracion\Exceptions\CannotFindSoftDeleteManagerException;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;

class SoftDeleteManagerResolver{
    public function __construct(
        /**
         * @var iterable<SoftDeleteManagerContract>
         */
        private iterable $strategies
    )
    {
    }

    public function resolve(SoftDeleteManagerTypes $repositoryType) : SoftDeleteManagerContract{
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($repositoryType)) {
                return $strategy;
            }
        }
        throw new CannotFindSoftDeleteManagerException('No se pudo resolver la estrategia de manejo de registros eliminados');
    }
}