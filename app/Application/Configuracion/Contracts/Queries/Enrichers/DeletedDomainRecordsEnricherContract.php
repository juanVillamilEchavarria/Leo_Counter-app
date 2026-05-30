<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\Contracts\Queries\Enrichers;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato para enriquecer colecciones de registros eliminados por dominio.
 */
interface DeletedDomainRecordsEnricherContract
{
    /**
     * Enriquecer la coleccion de items eliminados (modelos Eloquent) y devolver una coleccion de DTOs.
     *
     * @param CollectionContract $items
     * @return CollectionContract
     */
    public function enrich(CollectionContract $items): CollectionContract;
}
