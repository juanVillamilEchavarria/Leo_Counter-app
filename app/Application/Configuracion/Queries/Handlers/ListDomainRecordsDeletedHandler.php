<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\Queries\Handlers;

use App\Application\Configuracion\Queries\ListDomainRecordsDeletedQuery;
use App\Application\Configuracion\Resolvers\ListDeletedDomainRecordsResolver;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Handler que orquesta el listado de registros eliminados por dominio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Configuracion\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListDomainRecordsDeletedHandler
{
    public function __construct(
        private ListDeletedDomainRecordsResolver $resolver,
    ) {
    }

    public function __invoke(ListDomainRecordsDeletedQuery $query): CollectionContract
    {
        return $this->resolver->resolve($query->domain);
    }
}
