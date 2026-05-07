<?php
namespace App\Application\Presupuesto\Queries\Handlers;

use App\Application\Presupuesto\Queries\ListAllCurrentMonthPresupuestosQuery;
use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoQueryExecutorContract;
use App\Shared\Domain\Contracts\CollectionContract;
/**
 * Handler para la consulta de todos los presupuestos del mes actual.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */

final readonly class ListAllCurrentMonthPresupuestosHandler{

    public function __construct(
        private PresupuestoQueryExecutorContract $executor
    ){}
    public function __invoke(ListAllCurrentMonthPresupuestosQuery $query): CollectionContract
    {
        return $this->executor->execute($query);
    }
}