<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\Contracts\Queries\Executors;

use App\Shared\Application\Contracts\Queries\Executors\PaginatedTableQueryExecutorContract;

/**
 * Contrato que debe implementar el executor de paginación de tablas de transferencias.
 * Extiende el contrato genérico de paginación de tablas compartido.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
interface TransferenciaPaginatedTableQueryExecutorContract extends PaginatedTableQueryExecutorContract {}
