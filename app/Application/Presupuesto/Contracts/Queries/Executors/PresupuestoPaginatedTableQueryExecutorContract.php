<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Presupuesto\Contracts\Queries\Executors;

use App\Shared\Application\Contracts\Queries\Executors\PaginatedTableQueryExecutorContract;

/**
 * Contrato que debe implementar el executor de paginación de tablas de presupuestos.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\Contracts\Queries\Executors
 * @since 1.0.0
 * @version 1.0.0
 */
interface PresupuestoPaginatedTableQueryExecutorContract extends PaginatedTableQueryExecutorContract {}
