<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\MovimientoFijo\Contracts\Repositories;

use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\Contracts\RepositoryContract;
/**
 * Contrato del repositorio de escritura y busqueda puntual del agregado MovimientoFijo.
 * Define las operaciones permitidas sobre el agregado sin exponer detalles de persistencia.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoFijo\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface MovimientoFijoRepositoryContract extends RepositoryContract
{
}
