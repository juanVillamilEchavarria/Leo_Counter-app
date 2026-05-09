<?php

namespace App\Application\Presupuesto\Contracts\Queries;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato para enriquecer la coleccion de presupuestos del mes actual antes de enviarla a la capa de presentacion.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\Contracts\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
interface CurrentMonthPresupuestoCollectionEnricherContract
{
    /**
     * Enriquecer la coleccion de presupuestos con datos derivados (por ejemplo isDuplicate).
     *
     * @param CollectionContract $items Coleccion de items a enriquecer
     * @param CollectionContract $duplicatedCategoriaIds Lista de categoria_id duplicadas para el proximo periodo
     * @return CollectionContract Nueva coleccion enriquecida
     */
    public function enrich(CollectionContract $items, CollectionContract $duplicatedCategoriaIds): CollectionContract;
}
