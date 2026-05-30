<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\Mappers;

use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Application\Reporte\Queries\GenerateFinancialReportQuery;
use App\Application\Reporte\Specifications\DefaultDateRangeSpecification;
use App\Domains\Reporte\ValueObjects\DateRange;
use App\Application\Reporte\Resolvers\Granularity\ReportGranularityResolver;
use App\Shared\Domain\ValueObjects\Ids;
use App\Application\Reporte\Specifications\IdsSpecification;
use DateTimeImmutable;


/**
 * Mapper para instanciar ReportQuery usando el DTO GenerateFinancialReportQuery
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @package App\Application\Reporte\Mappers
 * @see GenerateFinancialReportQuery
 */
final class ReportQueryMapper
{
    public function __construct(
        private readonly ReportGranularityResolver $granularityResolver,
        private readonly DefaultDateRangeSpecification $dateRangeSpec,
        private readonly IdsSpecification $idsSpec,
    ) {}

    /**
     * Instancia el ReportQuery usando el DTO GenerateFinancialReportQuery
     * @param GenerateFinancialReportQuery $dto
     * @return ReporteQuery
     *
     */
    public function map(GenerateFinancialReportQuery $dto): ReporteQuery
    {
        $dateRange = $this->resolveDateRange($dto);

        return new ReporteQuery(
            granularityStrategy:   $this->granularityResolver->resolve($dateRange->diffDays()),
            dateRange:             $dateRange,
            only_categorias_fijas: $dto->only_categorias_fijas,
            categorias:            $this->resolveIds($dto->categorias),
            cuentas:               $this->resolveIds($dto->cuentas)
        );
    }
    /**
     * Resuelve el rango de fechas para el reporte
     * @param GenerateFinancialReportQuery $dto
     * @return DateRange
     */

    private function resolveDateRange(GenerateFinancialReportQuery $dto): DateRange
    {
       if ($this->dateRangeSpec->isSatisfiedBy($dto->startDate, $dto->endDate)) {
           return DateRange::lastSixMonths();
       }
       $startDate = new DateTimeImmutable($dto->startDate);
       $endDate = new DateTimeImmutable($dto->endDate);
        return new DateRange($startDate, $endDate);
    }

    /**
     * Resuelve los ids instanciando Ids mediante la satisfaccion de la especificacion del dominio
     * @param iterable | null $property
     * @return ?Ids
     */
    private function resolveIds(?iterable $property): ?Ids
    {
        return $this->idsSpec->isSatisfiedBy($property)
                  ? Ids::fromArray($property)
                  : null;
    }

}
