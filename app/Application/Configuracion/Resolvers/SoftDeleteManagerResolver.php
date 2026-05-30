<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\Resolvers;

use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Exceptions\CannotFindSoftDeleteManagerException;

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
