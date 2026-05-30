<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Usuario\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query para obtener los datos de edición del usuario autenticado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Usuario\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetUsuarioForEditQuery implements QueryContract
{
    public function __construct(
        public string $id,
    ) {
    }
}
