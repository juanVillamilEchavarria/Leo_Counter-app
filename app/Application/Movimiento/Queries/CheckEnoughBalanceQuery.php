<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Queries;

use App\Shared\Application\Contracts\Queries\QueryContract;

/**
 * Query para verificar si hay suficiente saldo en una cuenta.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CheckEnoughBalanceQuery implements QueryContract
{
    public function __construct(
        public string $cuenta_id,
        public float $monto
    )
    {
    }

}
