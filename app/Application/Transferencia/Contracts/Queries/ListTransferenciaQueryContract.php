<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\Contracts\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Contrato marcador para queries de listado del modulo Transferencia.
 * Permite que los query executors reciban distintas consultas de lectura sin acoplarse a clases concretas.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
interface ListTransferenciaQueryContract extends QueryContract
{
}