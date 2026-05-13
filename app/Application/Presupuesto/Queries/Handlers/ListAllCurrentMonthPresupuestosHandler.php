<?php

namespace App\Application\Presupuesto\Queries\Handlers;

use App\Application\Presupuesto\Queries\ListAllCurrentMonthPresupuestosQuery;
use App\Application\Presupuesto\Contracts\Queries\Executors\PresupuestoQueryExecutorContract;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoCanDuplicateCheckerContract;
use App\Application\Presupuesto\Contracts\Queries\CurrentMonthPresupuestoCollectionEnricherContract;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;
use DateInterval;

/**
 * Handler para la consulta de todos los presupuestos del mes actual.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */

final readonly class ListAllCurrentMonthPresupuestosHandler{

    public function __construct(
        private PresupuestoQueryExecutorContract $executor,
        private PresupuestoCanDuplicateCheckerContract $duplicateChecker,
        private CurrentMonthPresupuestoCollectionEnricherContract $enricher
    ){}

    public function __invoke(ListAllCurrentMonthPresupuestosQuery $query): CollectionContract
    {
        $items = $this->executor->execute($query);
        $nextMonth = (new Date(new DateTimeImmutable()))->addMonths();
        $duplicatedIds = $this->duplicateChecker->findDuplicatedCategories($items, $nextMonth);

        return $this->enricher->enrich($items, $duplicatedIds);
    }
}
