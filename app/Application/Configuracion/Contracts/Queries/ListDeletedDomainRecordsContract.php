<?php

namespace App\Application\Configuracion\Contracts\Queries;

use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Domain\Contracts\CollectionContract;

/**
 * Contrato para estrategias de listado de registros eliminados por dominio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Configuracion\Contracts\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
interface ListDeletedDomainRecordsContract
{
    /**
     * Determina si la estrategia soporta el tipo de dominio solicitado.
     *
     * @param SoftDeleteManagerTypes $type Tipo de dominio eliminado.
     * @return bool
     */
    public function supports(SoftDeleteManagerTypes $type): bool;

    /**
     * Ejecuta el listado de registros eliminados del dominio soportado.
     *
     * @return CollectionContract
     */
    public function execute(): CollectionContract;
}
