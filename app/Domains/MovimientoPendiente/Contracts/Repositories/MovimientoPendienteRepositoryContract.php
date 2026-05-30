<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\MovimientoPendiente\Contracts\Repositories;

use App\Shared\Domain\Contracts\RepositoryContract;
use App\Shared\Domain\Contracts\SoftDeleteRepositoryContract;

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
