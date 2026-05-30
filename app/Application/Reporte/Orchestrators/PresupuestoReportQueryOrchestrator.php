<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\Orchestrators;

use App\Application\Reporte\Contracts\Orchestrators\DomainReportQueryOrchestrator;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract;
use App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;

final readonly class PresupuestoReportQueryOrchestrator implements DomainReportQueryOrchestrator
{

    /** @var array<ReporteQueryExecutorContract> */
    private array $executors;   
 public function __construct(iterable $executors) {
        $this->executors = is_array($executors) ? $executors : iterator_to_array($executors);
    }


    public function get(ReportStatisticTypeContract $type, ReporteQuery $dto): mixed
    {
        /**
         * @var ReporteQueryExecutorContract $executor
         */
        foreach ($this->executors as $executor) {
            if ($executor->supports($type)) {
                return $executor->execute($dto);
            }
        }

        throw new \InvalidArgumentException("QueryExecutor no encontrado para el tipo: {$type->value}");
    }

    public function getMultiple(array $types, ReporteQuery $dto): ReporteQueryResult
    {
        $result = new ReporteQueryResult();

        /** @var ReportStatisticTypeContract $type */
        foreach ($types as $type) {
            if(!$type instanceof PresupuestoReportStatisticType){
                continue;
            }
            $result = $result->add($type, $this->get($type, $dto));
        }

        return $result;
    }
}