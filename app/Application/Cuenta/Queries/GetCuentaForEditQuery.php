<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Cuenta\Queries;
use App\Shared\Application\Contracts\Queries\QueryContract;
/**
 * Query para obtener una cuenta para edición, trayendo la información necesaria
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Cuenta\Queries
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetCuentaForEditQuery implements QueryContract {
    public function __construct(
        public string $id
    )
    {
    }
}
