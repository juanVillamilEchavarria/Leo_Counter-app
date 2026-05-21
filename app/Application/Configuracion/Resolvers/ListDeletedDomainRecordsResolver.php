<?php

namespace App\Application\Configuracion\Resolvers;

use App\Application\Configuracion\Contracts\Queries\ListDeletedDomainRecordsContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Exceptions\CannotFindSoftDeleteManagerException;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Resolver de estrategias de listado de registros eliminados por dominio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Configuracion\Resolvers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListDeletedDomainRecordsResolver
{
    public function __construct(
        /**
         * @var iterable<ListDeletedDomainRecordsContract>
         */
        private iterable $strategies,
    ) {
    }

    /**
     * Resuelve y ejecuta la estrategia compatible con el dominio solicitado.
     *
     * @param SoftDeleteManagerTypes $type Tipo de dominio eliminado.
     * @return CollectionContract
     */
    public function resolve(SoftDeleteManagerTypes $type): CollectionContract
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($type)) {
                return $strategy->execute();
            }
        }

        throw new CannotFindSoftDeleteManagerException('No se pudo resolver la estrategia de listado de registros eliminados');
    }
}
