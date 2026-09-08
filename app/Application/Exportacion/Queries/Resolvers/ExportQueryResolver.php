<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Queries\Resolvers;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use LogicException;

/**
 * Resolver de estrategias de exportación.
 * Sigue el patrón canónico del proyecto: recibe un iterable de estrategias y
 * selecciona la adecuada iterando con foreach + supports().
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ExportQueryResolver
{
    /**
     * @param  iterable<ExportQueryStrategyContract>  $strategies
     */
    public function __construct(
        private iterable $strategies
    ) {}

    /**
     * Resuelve la estrategia de exportación adecuada para la tabla solicitada.
     *
     * @throws LogicException Si no se encuentra una estrategia que soporte la tabla
     */
    public function resolve(ExportableTable $table): ExportQueryStrategyContract
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($table)) {
                return $strategy;
            }
        }

        throw new LogicException(
            "No se encontró una estrategia de exportación para la tabla: {$table->value}"
        );
    }
}
