<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Queries\Handlers;

use App\Application\Exportacion\DTOs\ExportDataResultDTO;
use App\Application\Exportacion\Queries\ExportDataQuery;
use App\Application\Exportacion\Queries\Resolvers\ExportQueryResolver;

/**
 * Handler único de exportación. Resuelve la estrategia correspondiente a la tabla
 * solicitada y delega en ella la construcción del resultado de exportación.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ExportDataHandler
{
    public function __construct(
        private ExportQueryResolver $resolver
    ) {}

    public function __invoke(ExportDataQuery $query): ExportDataResultDTO
    {
        $strategy = $this->resolver->resolve($query->table);

        return $strategy->export($query);
    }
}
