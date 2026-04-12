<?php

namespace App\Application\Reporte\Mappers;

use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Application\Reporte\DTOs\ReportGenerationDTO;
use App\Domains\Reporte\Specifications\DefaultDateRangeSpecification;
use App\Domains\Reporte\ValueObjects\DateRange;
use App\Domains\Reporte\Strategies\Resolvers\Granularity\ReportGranularityResolver;
use App\Shared\DTOs\Querys\IdsDTO;
use App\Domains\Reporte\Specifications\IdsSpecification;
use DateTimeImmutable;

/**
 * Mapper para instanciar ReportQuery usando el DTO ReportGenerationDTO
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @package App\Application\Reporte\Mappers
 */
final class ReportQueryMapper
{
    public function __construct(
        private readonly ReportGranularityResolver $granularityResolver,
        private readonly DefaultDateRangeSpecification $dateRangeSpec,
        private readonly IdsSpecification $idsSpec,
    ) {}

    /**
     * Instancia el ReportQuery usando el DTO ReportGenerationDTO
     * @param ReportGenerationDTO $dto
     * @return ReporteQueryDTO
     * 
     */
    public function map(ReportGenerationDTO $dto): ReporteQueryDTO
    {
        $dateRange = $this->resolveDateRange($dto);

        return new ReporteQueryDTO(
            granularityStrategy:   $this->granularityResolver->resolve($dateRange->diffDays()),
            dateRange:             $dateRange,
            only_categorias_fijas: $dto->only_categorias_fijas,
            categorias:            $this->resolveIds($dto->categorias),
            cuentas:               $this->resolveIds($dto->cuentas)
        );
    }
    /**
     * Resuelve el rango de fechas para el reporte
     * @param ReportGenerationDTO $dto
     * @return DateRange
     */

    private function resolveDateRange(ReportGenerationDTO $dto): DateRange
    {
       if ($this->dateRangeSpec->isSatisfiedBy($dto->startDate, $dto->endDate)) {
           return DateRange::lastSixMonths();
       }
       $startDate = new DateTimeImmutable($dto->startDate);
       $endDate = new DateTimeImmutable($dto->endDate);
        return new DateRange($startDate, $endDate);
    }

    /**
     * Resuelve los ids instanciando IdsDTO mediante la satisfaccion de la especificacion del dominio
     * @param iterable $property
     * @return ?IdsDTO
     */
    private function resolveIds(?iterable $property): ?IdsDTO
    {
        return $this->idsSpec->isSatisfiedBy($property)  
                  ? IdsDTO::fromArray($property)       
                  : null;
    }

}