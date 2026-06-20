<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Contracts\Queries;
use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Contrato que deben implementar todos los queries de categorias.
 * Este contrato se pasar a los query executors para permitir consultas de diferentes filtros sin acoplar el executor contract a una clase de query específica.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Contracts\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
interface ListCategoriasQueryContract extends QueryContract
{
}
