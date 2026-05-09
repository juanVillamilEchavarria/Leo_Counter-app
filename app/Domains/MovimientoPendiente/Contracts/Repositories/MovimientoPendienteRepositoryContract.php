<?php

namespace App\Domains\MovimientoPendiente\Contracts\Repositories;

use App\Shared\Contracts\Repositories\SoftDeleteRepositoryContract;
use App\Shared\Domain\Contracts\RepositoryContract;

/**
 * Contrato de repositorio para MovimientoPendiente.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoPendiente\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 *
 */
interface MovimientoPendienteRepositoryContract extends  RepositoryContract ,SoftDeleteRepositoryContract
{
}
