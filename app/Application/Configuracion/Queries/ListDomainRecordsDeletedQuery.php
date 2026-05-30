<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;

/**
 * Query para listar los registros eliminados de un dominio de Configuración.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Configuracion\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListDomainRecordsDeletedQuery implements QueryContract
{
    public function __construct(
        public SoftDeleteManagerTypes $domain,
    ) {
    }
}
