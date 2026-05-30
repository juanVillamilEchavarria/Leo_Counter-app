<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Queries\Handlers;

use App\Application\Movimiento\Contracts\Queries\Executors\MovimientoForShowQueryExecutorContract;
use App\Application\Movimiento\Queries\GetMovimientoForShowQuery;
use App\Application\Movimiento\DTOs\MovimientoShowDTO;
use App\Domains\Movimiento\ValueObjects\MovimientoId;

final readonly class GetMovimientoForShowHandler
{
    public function __construct(
        private MovimientoForShowQueryExecutorContract $executor
    )
    {
    }
    public function __invoke(GetMovimientoForShowQuery $query): MovimientoShowDTO
    {
        return $this->executor->execute(new MovimientoId($query->id));
    }

}
