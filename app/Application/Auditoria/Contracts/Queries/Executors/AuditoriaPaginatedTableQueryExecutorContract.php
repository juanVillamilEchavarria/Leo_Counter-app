<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Auditoria\Contracts\Queries\Executors;

use App\Shared\Application\Contracts\Queries\Executors\PaginatedTableQueryExecutorContract;

/**
 * Contrato que debe implementar el executor de paginación de tablas de auditorías.
 * Sigue el mismo patrón que los ejecutores paginados de otros módulos como Movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
interface AuditoriaPaginatedTableQueryExecutorContract extends PaginatedTableQueryExecutorContract {}
