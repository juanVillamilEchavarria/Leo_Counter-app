<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Contracts\Queries\Strategies;

use App\Application\Exportacion\DTOs\ExportDataResultDTO;
use App\Application\Exportacion\Queries\ExportDataQuery;
use App\Domains\Exportacion\Enums\ExportableTable;

/**
 * Contrato base de la estrategia de exportación.
 * Cada módulo implementará una estrategia concreta que soporte una tabla exportable.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
interface ExportQueryStrategyContract
{
    /**
     * Indica si esta estrategia puede manejar la tabla solicitada.
     */
    public function supports(ExportableTable $table): bool;

    /**
     * Ejecuta la exportación y devuelve los datos estructurados.
     */
    public function export(ExportDataQuery $query): ExportDataResultDTO;
}
